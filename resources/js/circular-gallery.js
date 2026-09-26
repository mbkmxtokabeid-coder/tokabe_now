import { Camera, Mesh, Plane, Program, Renderer, Texture, Transform, Raycast, Vec2 } from 'ogl';

function debounce(func, wait) {
    let timeout;
    return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}

function lerp(p1, p2, t) {
    return p1 + (p2 - p1) * t;
}

function autoBind(instance) {
    const proto = Object.getPrototypeOf(instance);
    Object.getOwnPropertyNames(proto).forEach(key => {
        if (key !== 'constructor' && typeof instance[key] === 'function') {
            instance[key] = instance[key].bind(instance);
        }
    });
}

function getFontSize(font) {
    const match = font.match(/(\d+)px/);
    return match ? parseInt(match[1], 10) : 30;
}

function createTextTexture(gl, text, category, date, font = 'bold 30px monospace', color = 'white', showButton = true, buttonText = 'Explore Now') {
    const canvas = document.createElement('canvas');
    const context = canvas.getContext('2d');

    const isMobile = window.innerWidth < 768;

    // =====================================================================
    // DESKTOP — kode stabil, jangan ubah
    // =====================================================================
    if (!isMobile) {
        canvas.width = 2048;
        canvas.height = 2048;

        const drawW = 1536;
        const drawH = 2048;

        context.clearRect(0, 0, canvas.width, canvas.height);

        const paddingX = 80;

        let subY;

        if (showButton) {
            const btnHeight = 220;
            const btnY = drawH - 80 - btnHeight;
            const btnWidth = drawW - (paddingX * 2);

            context.fillStyle = 'rgba(255, 255, 255, 0.15)';
            context.beginPath();
            context.roundRect(paddingX, btnY, btnWidth, btnHeight, 45);
            context.fill();

            context.fillStyle = 'white';
            context.font = 'bold 95px Figtree, sans-serif';
            context.textAlign = 'left';
            context.textBaseline = 'middle';
            context.fillText(buttonText, paddingX + 80, btnY + btnHeight / 2);

            context.font = 'bold 120px Figtree, sans-serif';
            context.textAlign = 'right';
            context.fillText('→', paddingX + btnWidth - 80, btnY + btnHeight / 2 - 5);

            subY = btnY - 60;
        } else {
            subY = drawH - 120;
        }

        // Subtitle
        context.fillStyle = 'rgba(255, 255, 255, 0.85)';
        context.font = '500 75px Figtree, sans-serif';
        context.textAlign = 'left';
        context.textBaseline = 'bottom';
        const subtext = (category && date) ? `${category} • ${date}` : (category || date || '');
        context.fillText(subtext, paddingX, subY);

        // Title
        context.fillStyle = 'white';
        context.font = 'bold 140px Figtree, sans-serif';
        const titleBaseY = subY - 80;
        const maxTitleWidth = drawW - (paddingX * 2);

        const words = text.split(' ');
        let line = '';
        const lines = [];
        for (let n = 0; n < words.length; n++) {
            const testLine = line + words[n] + ' ';
            const metrics = context.measureText(testLine);
            if (metrics.width > maxTitleWidth && n > 0) {
                lines.push(line.trim());
                line = words[n] + ' ';
            } else {
                line = testLine;
            }
        }
        lines.push(line.trim());

        const lineHeight = 155;
        let currentY = titleBaseY;
        for (let i = lines.length - 1; i >= 0; i--) {
            context.fillText(lines[i], paddingX, currentY);
            currentY -= lineHeight;
        }

        const texture = new Texture(gl, {
            generateMipmaps: true,
            premultiplyAlpha: true,
            minFilter: gl.LINEAR_MIPMAP_LINEAR,
            magFilter: gl.LINEAR,
            anisotropy: 16
        });
        texture.image = canvas;
        return { texture, width: canvas.width, height: canvas.height };
    }

    // =====================================================================
    // MOBILE — layout terpisah, semua ukuran proporsional ke 1024px
    // =====================================================================
    canvas.width = 1024;
    canvas.height = 1024;

    context.clearRect(0, 0, 1024, 1024);

    // Nilai absolut dalam px (canvas 1024×1024)
    const M = {
        paddingX: 50,   // margin kiri & kanan
        btnH: 88,   // tinggi button
        btnRadius: 18,
        btnTextSz: 40,   // "Explore Now"
        arrowSz: 46,
        subSz: 32,   // subtitle
        titleSz: 65,   // title
        lineH: 80,
        bottomPad: 48,   // jarak dari bawah canvas ke button
        gapBS: 18,   // button ↔ subtitle
        gapST: 40,   // subtitle ↔ title
        innerPad: 20,   // padding dalam button (kiri label & kanan arrow)
    };

    // PENTING: shader menggunakan 'vUv.x * 0.75' — hanya 75% kiri canvas yang terlihat.
    // Sama seperti desktop: drawW=1536 dari canvas 2048 = 75%.
    // Mobile: drawW = 1024 * 0.75 = 768px adalah batas kanan yang aman.
    const drawW = Math.round(1024 * 0.75);   // = 768px (visible area)
    const innerW = drawW - M.paddingX * 2;   // = 768 - 100 = 668px

    let subY;

    if (showButton) {
        // ── Button ────────────────────────────────────────────────────
        const btnY = 1024 - M.bottomPad - M.btnH;

        context.fillStyle = 'rgba(255,255,255,0.18)';
        context.beginPath();
        context.roundRect(M.paddingX, btnY, innerW, M.btnH, M.btnRadius);
        context.fill();

        // Label "Explore Now"
        context.fillStyle = 'white';
        context.font = `bold ${M.btnTextSz}px Figtree, sans-serif`;
        context.textAlign = 'left';
        context.textBaseline = 'middle';
        context.fillText(buttonText, M.paddingX + M.innerPad, btnY + M.btnH / 2);

        // Arrow — di sisi kanan button, dibatasi dengan textAlign:'right'
        context.font = `bold ${M.arrowSz}px Figtree, sans-serif`;
        context.textAlign = 'right';
        context.fillText('→', M.paddingX + innerW - M.innerPad, btnY + M.btnH / 2);

        subY = btnY - M.gapBS;
    } else {
        subY = 1024 - M.bottomPad;
    }

    // ── Subtitle ──────────────────────────────────────────────────────
    const subtext = (category && date) ? `${category} • ${date}` : (category || date || '');
    if (subtext) {
        context.fillStyle = 'rgba(255,255,255,0.85)';
        context.font = `500 ${M.subSz}px Figtree, sans-serif`;
        context.textAlign = 'left';
        context.textBaseline = 'bottom';
        // Potong subtitle dengan ellipsis jika masih overflow
        let sub = subtext;
        while (sub.length > 1 && context.measureText(sub).width > innerW) {
            sub = sub.slice(0, -1);
        }
        if (sub !== subtext) sub = sub.slice(0, -1) + '…';
        context.fillText(sub, M.paddingX, subY);
    }

    // ── Title (maks 2 baris, sisa kata → "...") ───────────────────────
    context.fillStyle = 'white';
    context.font = `bold ${M.titleSz}px Figtree, sans-serif`;

    const MAX_LINES = 2;
    const allWords = text.split(' ');
    let line = '';
    const lines = [];

    for (let n = 0; n < allWords.length; n++) {
        const testLine = line + allWords[n] + ' ';
        if (context.measureText(testLine).width > innerW && n > 0) {
            lines.push(line.trim());
            line = allWords[n] + ' ';
            // Jika sudah 2 baris, potong sisanya dengan "..."
            if (lines.length === MAX_LINES - 1 && n < allWords.length - 1) {
                // Masukkan sisa kata ke baris terakhir, potong dengan "..."
                let lastLine = line.trim();
                let remaining = allWords.slice(n + 1).join(' ');
                let candidate = lastLine + (remaining ? ' ' + remaining : '');
                // Potong karakter per karakter sampai muat + "..."
                let truncated = candidate;
                while (context.measureText(truncated + '...').width > innerW && truncated.length > 0) {
                    truncated = truncated.slice(0, -1).trimEnd();
                }
                lines.push(truncated + '...');
                line = '';
                break;
            }
        } else {
            line = testLine;
        }
    }
    if (line.trim()) lines.push(line.trim());

    // Gambar dari bawah ke atas
    let currentY = subY - M.gapST;
    for (let i = lines.length - 1; i >= 0; i--) {
        context.fillText(lines[i], M.paddingX, currentY);
        currentY -= M.lineH;
    }

    const texture = new Texture(gl, {
        generateMipmaps: false,   // mobile: hemat VRAM
        premultiplyAlpha: true,
        minFilter: gl.LINEAR,
        magFilter: gl.LINEAR,
        anisotropy: 1
    });
    texture.image = canvas;
    return { texture, width: canvas.width, height: canvas.height };
}

class Media {
    constructor({
        geometry,
        gl,
        image,
        index,
        length,
        renderer,
        scene,
        screen,
        text,
        category,
        date,
        url,
        viewport,
        bend,
        textColor,
        borderRadius = 0,
        font,
        showButton = true,
        buttonText = 'Explore Now'
    }) {
        this.extra = 0;
        this.geometry = geometry;
        this.gl = gl;
        this.image = image;
        this.index = index;
        this.length = length;
        this.renderer = renderer;
        this.scene = scene;
        this.screen = screen;
        this.text = text;
        this.category = category;
        this.date = date;
        this.url = url;
        this.viewport = viewport;
        this.bend = bend;
        this.textColor = textColor;
        this.borderRadius = borderRadius;
        this.font = font;
        this.showButton = showButton;
        this.buttonText = buttonText;
        this.createShader();
        this.createMesh();
        this.onResize();

    }
    createShader() {
        const texture = new Texture(this.gl, {
            generateMipmaps: true
        });
        const { texture: tText } = createTextTexture(this.gl, this.text, this.category, this.date, this.font, this.textColor, this.showButton, this.buttonText);

        this.program = new Program(this.gl, {
            depthTest: false,
            depthWrite: false,
            vertex: `
        precision highp float;
        attribute vec3 position;
        attribute vec2 uv;
        uniform mat4 modelViewMatrix;
        uniform mat4 projectionMatrix;
        varying vec2 vUv;
        void main() {
          vUv = uv;
          gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
        }
      `,
            fragment: `
        precision highp float;
        uniform vec2 uImageSizes;
        uniform vec2 uPlaneSizes;
        uniform sampler2D tMap;
        uniform sampler2D tText;
        uniform float uBorderRadius;
        uniform float uTime;
        uniform float uLoaded;
        varying vec2 vUv;
        
        float roundedBoxSDF(vec2 p, vec2 b, float r) {
          vec2 d = abs(p) - b;
          return length(max(d, vec2(0.0))) + min(max(d.x, d.y), 0.0) - r;
        }
        
        void main() {
          vec2 ratio = vec2(
            min((uPlaneSizes.x / uPlaneSizes.y) / (uImageSizes.x / uImageSizes.y), 1.0),
            min((uPlaneSizes.y / uPlaneSizes.x) / (uImageSizes.y / uImageSizes.x), 1.0)
          );
          vec2 uv = vec2(
            vUv.x * ratio.x + (1.0 - ratio.x) * 0.5,
            vUv.y * ratio.y + (1.0 - ratio.y) * 0.5
          );
          
          vec4 color = vec4(0.0);
          
          if (uLoaded < 0.5) {
              // Premium Skeleton Loader Effect
              // Base gradient from #3E2718 to #2C1A0E
              vec3 topColor = vec3(0.243, 0.153, 0.094); 
              vec3 bottomColor = vec3(0.173, 0.102, 0.055);
              vec3 gradColor = mix(topColor, bottomColor, vUv.y);
              
              // Read placeholder texture (gold icon and bar)
              vec4 placeholder = texture2D(tMap, uv);
              
              // Composite icon over gradient
              color.rgb = mix(gradColor, placeholder.rgb, placeholder.a);
              color.a = 1.0;
              
              // Animated Pulse
              float pulse = (sin(uTime * 2.0) * 0.5 + 0.5) * 0.15;
              color.rgb -= pulse; 
              
              // Diagonal Shimmer Band
              float shimmer = fract(vUv.x * 1.5 - vUv.y + uTime * 0.3);
              if (shimmer > 0.7) {
                  float intensity = smoothstep(0.7, 0.85, shimmer) * smoothstep(1.0, 0.85, shimmer);
                  color.rgb += intensity * 0.15;
              }
          } else {
              color = texture2D(tMap, uv);
          }
          
          // Add dark gradient overlay at the bottom
          float gradient = smoothstep(0.0, 0.7, vUv.y);
          // Match #2e1e10 (46, 30, 16)
          vec3 darkTint = vec3(0.18, 0.117, 0.062); 
          color.rgb = mix(darkTint, color.rgb, gradient);
          
          // Overlay Text
          vec4 textCol = texture2D(tText, vec2(vUv.x * 0.75, vUv.y));
          // Use premultiplied alpha blending to fix dark fringes and pixelation around text
          color.rgb = color.rgb * (1.0 - textCol.a) + textCol.rgb;
          
          float d = roundedBoxSDF(vUv - 0.5, vec2(0.5 - uBorderRadius), uBorderRadius);
          
          // Smooth antialiasing for edges
          float edgeSmooth = 0.002;
          float alpha = 1.0 - smoothstep(-edgeSmooth, edgeSmooth, d);
          
          gl_FragColor = vec4(color.rgb, alpha);
        }
      `,
            uniforms: {
                tMap: { value: texture },
                tText: { value: tText },
                uPlaneSizes: { value: [0, 0] },
                uImageSizes: { value: [1, 1] },
                uSpeed: { value: 0 },
                uTime: { value: 100 * Math.random() },
                uBorderRadius: { value: this.borderRadius },
                uLoaded: { value: 0.0 }
            },
            transparent: true
        });
        const tempCanvas = document.createElement('canvas');
        tempCanvas.width = 1024; tempCanvas.height = 1024;
        const ctx = tempCanvas.getContext('2d');

        // Draw icon and bar
        const cx = 512, cy = 512, iconSize = 240, barWidth = 180, barHeight = 20;

        ctx.save();
        ctx.translate(cx - iconSize / 2, cy - iconSize / 2 - 40);

        let x = 0, y = 0, w = iconSize, h = iconSize * 0.8, r = 24;
        ctx.beginPath();
        ctx.moveTo(x + r, y); ctx.lineTo(x + w - r, y); ctx.quadraticCurveTo(x + w, y, x + w, y + r); ctx.lineTo(x + w, y + h - r); ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h); ctx.lineTo(x + r, y + h); ctx.quadraticCurveTo(x, y + h, x, y + h - r); ctx.lineTo(x, y + r); ctx.quadraticCurveTo(x, y, x + r, y); ctx.closePath();
        ctx.lineWidth = 20;
        ctx.strokeStyle = 'rgba(212, 165, 116, 0.3)'; // #D4A574 with 30% opacity
        ctx.stroke();

        ctx.beginPath();
        ctx.arc(iconSize * 0.7, iconSize * 0.25, iconSize * 0.12, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(212, 165, 116, 0.3)';
        ctx.fill();

        ctx.save();
        ctx.beginPath();
        ctx.moveTo(x + r, y); ctx.lineTo(x + w - r, y); ctx.quadraticCurveTo(x + w, y, x + w, y + r); ctx.lineTo(x + w, y + h - r); ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h); ctx.lineTo(x + r, y + h); ctx.quadraticCurveTo(x, y + h, x, y + h - r); ctx.lineTo(x, y + r); ctx.quadraticCurveTo(x, y, x + r, y); ctx.closePath();
        ctx.clip();

        ctx.beginPath();
        ctx.moveTo(-iconSize * 0.1, iconSize * 0.9);
        ctx.lineTo(iconSize * 0.3, iconSize * 0.4);
        ctx.lineTo(iconSize * 0.6, iconSize * 0.8);
        ctx.lineTo(iconSize * 0.8, iconSize * 0.5);
        ctx.lineTo(iconSize * 1.2, iconSize * 0.9);
        ctx.closePath();
        ctx.fill();
        ctx.restore();
        ctx.restore();

        ctx.fillStyle = 'rgba(212, 165, 116, 0.2)'; // #D4A574 with 20% opacity
        ctx.beginPath();
        x = cx - barWidth / 2; y = cy + iconSize / 2 + 20; w = barWidth; h = barHeight; r = barHeight / 2;
        ctx.moveTo(x + r, y); ctx.lineTo(x + w - r, y); ctx.quadraticCurveTo(x + w, y, x + w, y + r); ctx.lineTo(x + w, y + h - r); ctx.quadraticCurveTo(x + w, y + h, x + w - r, y + h); ctx.lineTo(x + r, y + h); ctx.quadraticCurveTo(x, y + h, x, y + h - r); ctx.lineTo(x, y + r); ctx.quadraticCurveTo(x, y, x + r, y); ctx.closePath();
        ctx.fill();

        texture.image = tempCanvas;

        const img = new Image();
        img.crossOrigin = 'anonymous';
        img.src = this.image;
        img.onload = () => {
            texture.image = img;
            this.program.uniforms.uImageSizes.value = [img.naturalWidth, img.naturalHeight];
            this.program.uniforms.uLoaded.value = 1.0;
        };
    }
    createMesh() {
        this.plane = new Mesh(this.gl, {
            geometry: this.geometry,
            program: this.program
        });
        this.plane.setParent(this.scene);
        this.plane.parentMedia = this; // Attach reference for raycasting
    }
    createTitle() {
        this.title = new Title({
            gl: this.gl,
            plane: this.plane,
            renderer: this.renderer,
            text: this.text,
            category: this.category,
            date: this.date,
            textColor: this.textColor,
            font: this.font
        });
    }
    update(scroll, direction) {
        this.plane.position.x = this.x - scroll.current - this.extra;

        const x = this.plane.position.x;
        const H = this.viewport.width / 2;

        if (this.bend === 0) {
            this.plane.position.y = 0;
            this.plane.rotation.z = 0;
        } else {
            const B_abs = Math.abs(this.bend);
            const R = (H * H + B_abs * B_abs) / (2 * B_abs);
            const effectiveX = Math.min(Math.abs(x), H);

            const arc = R - Math.sqrt(R * R - effectiveX * effectiveX);
            if (this.bend > 0) {
                this.plane.position.y = -arc;
                this.plane.rotation.z = -Math.sign(x) * Math.asin(effectiveX / R);
            } else {
                this.plane.position.y = arc;
                this.plane.rotation.z = Math.sign(x) * Math.asin(effectiveX / R);
            }
        }

        this.speed = scroll.current - scroll.last;
        this.program.uniforms.uTime.value += 0.04;
        this.program.uniforms.uSpeed.value = this.speed;

        const planeOffset = this.plane.scale.x / 2;
        const viewportOffset = this.viewport.width / 2;
        this.isBefore = this.plane.position.x + planeOffset < -viewportOffset;
        this.isAfter = this.plane.position.x - planeOffset > viewportOffset;
        if (direction === 'right' && this.isBefore) {
            this.extra -= this.widthTotal;
            this.isBefore = this.isAfter = false;
        }
        if (direction === 'left' && this.isAfter) {
            this.extra += this.widthTotal;
            this.isBefore = this.isAfter = false;
        }
    }
    onResize({ screen, viewport } = {}) {
        if (screen) this.screen = screen;
        if (viewport) {
            this.viewport = viewport;
            if (this.plane.program.uniforms.uViewportSizes) {
                this.plane.program.uniforms.uViewportSizes.value = [this.viewport.width, this.viewport.height];
            }
        }
        this.scale = this.screen.height / 1500;
        this.plane.scale.y = (this.viewport.height * (1000 * this.scale)) / this.screen.height;
        this.plane.scale.x = (this.viewport.width * (750 * this.scale)) / this.screen.width;
        this.plane.program.uniforms.uPlaneSizes.value = [this.plane.scale.x, this.plane.scale.y];
        this.padding = 2;
        this.width = this.plane.scale.x + this.padding;
        this.widthTotal = this.width * this.length;
        this.x = this.width * this.index;

        if (this.title && this.title.mesh) {
            this.title.mesh.scale.set(this.plane.scale.x, this.plane.scale.y, 1);
        }
    }
}

class CircularGalleryApp {
    constructor(
        container,
        {
            items,
            bend,
            textColor = '#ffffff',
            borderRadius = 0,
            font = 'bold 30px Figtree',
            scrollSpeed = 2,
            scrollEase = 0.08,
            showButton = true,
            buttonText = 'Explore Now'
        } = {}
    ) {
        this.container = container;
        this.scrollSpeed = scrollSpeed;
        this.scroll = { ease: scrollEase, current: 0, target: 0, last: 0 };
        this.onCheckDebounce = debounce(this.onCheck.bind(this), 200);
        this.createRenderer();
        this.createCamera();
        this.createScene();
        this.onResize();
        this.createGeometry();
        this.createMedias(items, bend, textColor, borderRadius, font, showButton, buttonText);
        this.update();
        this.addEventListeners();

        // Raycast for clicking
        this.raycast = new Raycast(this.gl);
        this.mouse = new Vec2();
    }
    createRenderer() {
        const isMobile = window.innerWidth < 768;
        this.isMobile = isMobile;
        this.renderer = new Renderer({
            alpha: true,
            // Antialias di mobile = overhead besar, matikan
            antialias: !isMobile,
            // dpr max 1.5 di mobile agar tidak render terlalu banyak pixel
            dpr: isMobile ? Math.min(window.devicePixelRatio || 1, 1.5) : Math.min(window.devicePixelRatio || 1, 2)
        });
        this.gl = this.renderer.gl;
        this.gl.clearColor(0, 0, 0, 0);

        this.gl.canvas.addEventListener('webglcontextlost', (e) => {
            e.preventDefault();
            console.warn('[Gallery] WebGL context lost, stopping RAF');
            window.cancelAnimationFrame(this.raf);
        });
        this.gl.canvas.addEventListener('webglcontextrestored', () => {
            console.warn('[Gallery] WebGL context restored');
            this.update();
        });

        this.container.appendChild(this.gl.canvas);
    }
    createCamera() {
        this.camera = new Camera(this.gl);
        this.camera.fov = 45;
        this.camera.position.z = 20;
    }
    createScene() {
        this.scene = new Transform();
    }
    createGeometry() {
        // Mobile: segment lebih sedikit = vertex lebih sedikit = GPU lebih ringan
        this.planeGeometry = new Plane(this.gl, {
            heightSegments: this.isMobile ? 15 : 50,
            widthSegments: this.isMobile ? 15 : 100
        });
    }
    createMedias(items, bend = 1, textColor, borderRadius, font, showButton = true, buttonText = 'Explore Now') {
        const galleryItems = items && items.length ? items : [];
        // Mobile: jangan duplikasi items - terlalu banyak object WebGL
        this.mediasImages = this.isMobile ? galleryItems : galleryItems.concat(galleryItems);
        this.medias = this.mediasImages.map((data, index) => {
            return new Media({
                geometry: this.planeGeometry,
                gl: this.gl,
                image: data.image,
                index,
                length: this.mediasImages.length,
                renderer: this.renderer,
                scene: this.scene,
                screen: this.screen,
                text: data.text,
                category: data.category,
                date: data.date,
                url: data.url,
                viewport: this.viewport,
                bend,
                textColor,
                borderRadius,
                font,
                showButton,
                buttonText
            });
        });
    }
    onTouchDown(e) {
        this.isDown = true;
        this.scroll.position = this.scroll.current;
        this.start = e.touches ? e.touches[0].clientX : e.clientX;
        this.startY = e.touches ? e.touches[0].clientY : e.clientY;
        this.clickStart = { x: this.start, y: this.startY };
        this.dragDirectionDetermined = false;
    }
    onTouchMove(e) {
        if (!this.isDown) return;
        const x = e.touches ? e.touches[0].clientX : e.clientX;
        const y = e.touches ? e.touches[0].clientY : e.clientY;

        if (!this.dragDirectionDetermined) {
            const dx = Math.abs(x - this.start);
            const dy = Math.abs(y - this.startY);
            if (dx > 5 || dy > 5) {
                this.dragDirectionDetermined = true;
                if (dy > dx) {
                    this.isDown = false; // Vertical scroll, let browser handle it
                    return;
                }
            }
        }

        if (this.dragDirectionDetermined && e.cancelable) {
            e.preventDefault(); // Prevent page scrolling during horizontal swipe
        }

        const sensitivity = window.innerWidth < 768 ? 0.06 : 0.025; // More sensitive on mobile
        const distance = (this.start - x) * (this.scrollSpeed * sensitivity);
        this.scroll.target = this.scroll.position + distance;
    }
    onTouchUp(e) {
        this.isDown = false;
        this.onCheck();

        // Handle click if there wasn't much movement
        const currentX = e.changedTouches ? e.changedTouches[0].clientX : e.clientX;
        const currentY = e.changedTouches ? e.changedTouches[0].clientY : e.clientY;
        const distMoved = Math.hypot(currentX - this.clickStart.x, currentY - this.clickStart.y);

        if (distMoved < 10) {
            this.handleClick(currentX, currentY);
        }
    }
    handleClick(clientX, clientY) {
        const rect = this.container.getBoundingClientRect();
        this.mouse.set(
            ((clientX - rect.left) / rect.width) * 2 - 1,
            -((clientY - rect.top) / rect.height) * 2 + 1
        );

        this.raycast.castMouse(this.camera, this.mouse);
        const planes = this.medias.map(m => m.plane);
        const hits = this.raycast.intersectBounds(planes);

        if (hits.length > 0) {
            const hit = hits[0];
            const mesh = hit.mesh || hit;
            if (mesh && mesh.parentMedia && mesh.parentMedia.url) {
                window.location.href = mesh.parentMedia.url;
            }
        }
    }
    onWheel(e) {
        const delta = e.deltaY || e.wheelDelta || e.detail;
        this.scroll.target += (delta > 0 ? this.scrollSpeed : -this.scrollSpeed) * 0.2;
        this.onCheckDebounce();
    }
    onKeyDown(e) {
        switch (e.key) {
            case 'ArrowRight':
                e.preventDefault();
                this.scroll.target += this.scrollSpeed * 5;
                this.onCheckDebounce();
                break;
            case 'ArrowLeft':
                e.preventDefault();
                this.scroll.target -= this.scrollSpeed * 5;
                this.onCheckDebounce();
                break;
            default:
                break;
        }
    }
    onCheck() {
        if (!this.medias || !this.medias[0]) return;
        const width = this.medias[0].width;
        const itemIndex = Math.round(Math.abs(this.scroll.target) / width);
        const item = width * itemIndex;
        this.scroll.target = this.scroll.target < 0 ? -item : item;
    }
    onResize() {
        this.screen = {
            width: this.container.clientWidth,
            height: this.container.clientHeight
        };
        this.renderer.setSize(this.screen.width, this.screen.height);
        this.camera.perspective({
            aspect: this.screen.width / this.screen.height
        });
        const fov = (this.camera.fov * Math.PI) / 180;
        const height = 2 * Math.tan(fov / 2) * this.camera.position.z;
        const width = height * this.camera.aspect;
        this.viewport = { width, height };
        if (this.medias) {
            this.medias.forEach(media => media.onResize({ screen: this.screen, viewport: this.viewport }));
        }
    }
    update() {
        this.scroll.current = lerp(this.scroll.current, this.scroll.target, this.scroll.ease);
        const direction = this.scroll.current > this.scroll.last ? 'right' : 'left';
        if (this.medias) {
            this.medias.forEach(media => media.update(this.scroll, direction));
        }
        this.renderer.render({ scene: this.scene, camera: this.camera });
        this.scroll.last = this.scroll.current;
        this.raf = window.requestAnimationFrame(this.update.bind(this));
    }
    addEventListeners() {
        this.boundOnResize = this.onResize.bind(this);
        this.boundOnWheel = this.onWheel.bind(this);
        this.boundOnTouchDown = this.onTouchDown.bind(this);
        this.boundOnTouchMove = this.onTouchMove.bind(this);
        this.boundOnTouchUp = this.onTouchUp.bind(this);
        this.boundOnKeyDown = this.onKeyDown.bind(this);
        window.addEventListener('resize', this.boundOnResize);
        this.container.addEventListener('wheel', this.boundOnWheel, { passive: true });
        this.container.addEventListener('mousedown', this.boundOnTouchDown);
        window.addEventListener('mousemove', this.boundOnTouchMove);
        window.addEventListener('mouseup', this.boundOnTouchUp);
        this.container.addEventListener('touchstart', this.boundOnTouchDown, { passive: true });
        // passive: false WAJIB di container (bukan window) agar e.preventDefault() bisa dipanggil
        // Menaruhnya di window membuat SEMUA scroll halaman jadi non-passive → freeze di Android
        this.container.addEventListener('touchmove', this.boundOnTouchMove, { passive: false });
        window.addEventListener('touchend', this.boundOnTouchUp);

        this.container?.addEventListener('keydown', this.boundOnKeyDown);
    }
    destroy() {
        window.cancelAnimationFrame(this.raf);
        window.removeEventListener('resize', this.boundOnResize);
        this.container.removeEventListener('wheel', this.boundOnWheel);
        this.container.removeEventListener('mousedown', this.boundOnTouchDown);
        window.removeEventListener('mousemove', this.boundOnTouchMove);
        window.removeEventListener('mouseup', this.boundOnTouchUp);
        this.container.removeEventListener('touchstart', this.boundOnTouchDown);
        this.container.removeEventListener('touchmove', this.boundOnTouchMove);
        window.removeEventListener('touchend', this.boundOnTouchUp);
        if (this.renderer && this.renderer.gl && this.renderer.gl.canvas.parentNode) {
            this.renderer.gl.canvas.parentNode.removeChild(this.renderer.gl.canvas);
        }

        if (this.container) {
            this.container.removeEventListener('keydown', this.boundOnKeyDown);
        }
    }
}

// Attach to window so it can be called from inline scripts
window.CircularGalleryApp = CircularGalleryApp;
