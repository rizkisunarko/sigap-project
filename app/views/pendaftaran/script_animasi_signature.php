<script>
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, once: true });
    }
</script>

<script>
    (function(){
        const canvas = document.getElementById('signature-pad');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let drawing = false;
        let lastX = 0;
        let lastY = 0;

        function resizeCanvas() {
            const parent = canvas.parentElement;
            const w = parent.clientWidth;
            const h = parent.clientHeight;
            canvas.width = w;
            canvas.height = h;
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#111';
        }
        resizeCanvas();
        window.addEventListener('resize', resizeCanvas);

        const placeholder = document.getElementById('signature-placeholder');
        const clearSignature = document.getElementById('clear-signature');

        function pointerDown(e) {
            drawing = true;
            if (placeholder) placeholder.style.display = 'none';
            const rect = canvas.getBoundingClientRect();
            lastX = (e.clientX || (e.touches && e.touches[0].clientX)) - rect.left;
            lastY = (e.clientY || (e.touches && e.touches[0].clientY)) - rect.top;
        }
        function pointerMove(e) {
            if (!drawing) return;
            const rect = canvas.getBoundingClientRect();
            const clientX = e.clientX || (e.touches && e.touches[0].clientX);
            const clientY = e.clientY || (e.touches && e.touches[0].clientY);
            const x = (clientX - rect.left);
            const y = (clientY - rect.top);
            ctx.beginPath();
            ctx.moveTo(lastX, lastY);
            ctx.lineTo(x, y);
            ctx.stroke();
            lastX = x;
            lastY = y;
        }
        function pointerUp(e) {
            drawing = false;
        }

        canvas.addEventListener('pointerdown', pointerDown);
        canvas.addEventListener('pointermove', pointerMove);
        canvas.addEventListener('pointerup', pointerUp);
        canvas.addEventListener('pointercancel', pointerUp);
        canvas.addEventListener('touchstart', function(e){ e.preventDefault(); pointerDown(e); }, { passive: false });
        canvas.addEventListener('touchmove', function(e){ e.preventDefault(); pointerMove(e); }, { passive: false });
        canvas.addEventListener('touchend', function(e){ e.preventDefault(); pointerUp(e); });

        if (clearSignature) {
            clearSignature.addEventListener('click', function(e){
                e.preventDefault();
                ctx.clearRect(0,0,canvas.width,canvas.height);
                ctx.setTransform(1,0,0,1,0,0);
                resizeCanvas();
                if (placeholder) placeholder.style.display = 'flex';
                const ttdInput = document.getElementById('ttd_wali');
                if (ttdInput) ttdInput.value = '';
            });
        }

        const form = canvas.closest('form');
        if (form) {
            form.addEventListener('submit', function(e){
                const dataUrl = canvas.toDataURL('image/png');
                const isBlank = isCanvasBlank(canvas);
                if (isBlank) {
                    document.getElementById('ttd_wali').value = '';
                } else {
                    document.getElementById('ttd_wali').value = dataUrl;
                }
            });
        }

        function isCanvasBlank(cnv) {
            try {
                const w = cnv.width;
                const h = cnv.height;
                const img = ctx.getImageData(0, 0, w, h).data;
                for (let i = 0; i < img.length; i += 4) {
                    const r = img[i], g = img[i+1], b = img[i+2], a = img[i+3];
                    if (a !== 0 && !(r === 255 && g === 255 && b === 255)) {
                        return false;
                    }
                }
                return true;
            } catch (err) {
                return false;
            }
        }

        window.addEventListener('resize', function(){
            const data = canvas.toDataURL();
            resizeCanvas();
            const img = new Image();
            img.onload = function(){
                ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
            };
            img.src = data;
        });

        try {
            if (placeholder && isCanvasBlank(canvas)) {
                placeholder.style.display = 'flex';
            }
        } catch (err) {
            
        }
    })();
</script>