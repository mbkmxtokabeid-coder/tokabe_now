/**
 * Global Image Cropper Handler for Tokabe Admin Panel
 * Uses Cropper.js & DataTransfer API
 */

document.addEventListener('DOMContentLoaded', function () {
    let cropper = null;
    let currentInput = null;
    let currentFile = null;

    const modalEl = document.getElementById('cropperModal');
    if (!modalEl) return;

    const modal = new bootstrap.Modal(modalEl, { backdrop: 'static', keyboard: false });
    const cropImage = document.getElementById('cropperModalImage');
    const btnCropSave = document.getElementById('cropperModalSave');
    const ratioButtons = document.querySelectorAll('[data-aspect]');

    // Listen to changes on image inputs with class .crop-image-input or data-crop="true"
    document.addEventListener('change', function (e) {
        const input = e.target;
        if (!input.matches('.crop-image-input, [data-crop="true"], input[type="file"][accept*="image"]')) return;
        if (!input.files || !input.files[0]) return;
        if (input.getAttribute('data-no-crop') === 'true') return;

        const file = input.files[0];
        if (!file.type.startsWith('image/')) return;

        currentInput = input;
        currentFile = file;

        const reader = new FileReader();
        reader.onload = function (evt) {
            cropImage.src = evt.target.result;
            
            // Set initial aspect ratio from input attribute if present, default to 0 (free)
            const attrRatio = input.getAttribute('data-aspect-ratio');
            let initialRatio = NaN; // Free
            if (attrRatio === '16/9' || attrRatio === '16:9') initialRatio = 16 / 9;
            else if (attrRatio === '4/3' || attrRatio === '4:3') initialRatio = 4 / 3;
            else if (attrRatio === '1/1' || attrRatio === '1:1') initialRatio = 1;
            
            // Highlight ratio button
            ratioButtons.forEach(b => {
                const bRatio = b.getAttribute('data-aspect');
                if ((attrRatio === bRatio) || (!attrRatio && bRatio === 'free')) {
                    b.classList.add('btn-primary', 'active');
                    b.classList.remove('btn-outline-primary');
                } else {
                    b.classList.remove('btn-primary', 'active');
                    b.classList.add('btn-outline-primary');
                }
            });

            modal.show();

            // Destroy previous instance if any
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            // Init Cropper after modal is shown
            modalEl.addEventListener('shown.bs.modal', function onShown() {
                modalEl.removeEventListener('shown.bs.modal', onShown);
                cropper = new Cropper(cropImage, {
                    aspectRatio: initialRatio,
                    viewMode: 1,
                    autoCropArea: 0.95,
                    responsive: true,
                    background: false,
                    movable: true,
                    zoomable: true,
                    rotatable: true,
                    scalable: true
                });
            });
        };
        reader.readAsDataURL(file);
    });

    // Ratio Switch Buttons
    ratioButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            if (!cropper) return;
            ratioButtons.forEach(b => {
                b.classList.remove('btn-primary', 'active');
                b.classList.add('btn-outline-primary');
            });
            btn.classList.add('btn-primary', 'active');
            btn.classList.remove('btn-outline-primary');
            
            const ratioVal = btn.getAttribute('data-aspect');
            if (ratioVal === '16/9') cropper.setAspectRatio(16 / 9);
            else if (ratioVal === '4/3') cropper.setAspectRatio(4 / 3);
            else if (ratioVal === '1/1') cropper.setAspectRatio(1);
            else cropper.setAspectRatio(NaN); // Free
        });
    });

    // Save Cropped Image
    if (btnCropSave) {
        btnCropSave.addEventListener('click', function () {
            if (!cropper || !currentInput) return;

            const canvas = cropper.getCroppedCanvas({
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            if (!canvas) return;

            canvas.toBlob(function (blob) {
                if (!blob) return;

                // Create new File object
                const croppedFile = new File([blob], currentFile.name, {
                    type: currentFile.type || 'image/jpeg',
                    lastModified: Date.now()
                });

                // Update input.files using DataTransfer API
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(croppedFile);
                currentInput.files = dataTransfer.files;

                // Update Live Preview Image if specified
                const previewTargetSelector = currentInput.getAttribute('data-preview');
                if (previewTargetSelector) {
                    const previewImg = document.querySelector(previewTargetSelector);
                    if (previewImg) {
                        previewImg.src = URL.createObjectURL(croppedFile);
                        previewImg.style.display = 'block';
                    }
                } else {
                    // Look for common preview IDs/classes nearby
                    const formGroup = currentInput.closest('.form-group') || currentInput.parentElement;
                    if (formGroup) {
                        const nearbyImg = formGroup.querySelector('img');
                        if (nearbyImg) {
                            nearbyImg.src = URL.createObjectURL(croppedFile);
                            nearbyImg.style.display = 'block';
                        }
                    }
                }

                // Hide modal and cleanup
                modal.hide();
                if (cropper) {
                    cropper.destroy();
                    cropper = null;
                }
            }, currentFile.type || 'image/jpeg', 0.92);
        });
    }

    // Cleanup on modal hidden
    modalEl.addEventListener('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
        cropImage.src = '';
    });
});
