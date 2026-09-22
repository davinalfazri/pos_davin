{{--
    Lightbox Foto Global (mirip preview foto profil WhatsApp)
    ------------------------------------------------------------------
    Cara pakai: tambahkan class="zoomable-img" pada tag <img> mana pun
    di halaman manapun, maka foto tersebut otomatis bisa diklik untuk
    diperbesar tanpa perlu pindah halaman.

    Untuk elemen yang BUKAN <img> (misalnya <div> pembungkus QRIS),
    tambahkan atribut data-zoomable-src="{{ url foto }}" pada elemen
    tersebut.
--}}
<div id="imageLightbox" class="image-lightbox-overlay" aria-hidden="true">
    <button type="button" class="image-lightbox-close" aria-label="Tutup">
        <i class="bi bi-x-lg"></i>
    </button>
    <img id="imageLightboxImg" src="" alt="Preview">
    <div id="imageLightboxCaption" class="image-lightbox-caption"></div>
</div>

<style>
    .zoomable-img,
    [data-zoomable-src] {
        cursor: zoom-in;
    }

    .image-lightbox-overlay {
        position: fixed;
        inset: 0;
        z-index: 2000;
        background: rgba(2, 6, 15, 0.92);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.25s ease;
        padding: 2rem;
    }

    .image-lightbox-overlay.is-open {
        opacity: 1;
        visibility: visible;
    }

    .image-lightbox-overlay img {
        max-width: 90vw;
        max-height: 85vh;
        object-fit: contain;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
        transform: scale(0.85);
        transition: transform 0.25s ease;
        background: #fff;
    }

    .image-lightbox-overlay.is-open img {
        transform: scale(1);
    }

    .image-lightbox-close {
        position: absolute;
        top: 20px;
        right: 24px;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 1px solid rgba(255, 255, 255, 0.25);
        background: rgba(255, 255, 255, 0.08);
        color: #f8fafc;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s ease;
    }

    .image-lightbox-close:hover {
        background: rgba(255, 255, 255, 0.18);
    }

    .image-lightbox-caption {
        position: absolute;
        bottom: 28px;
        left: 0;
        right: 0;
        text-align: center;
        color: #cbd5e1;
        font-size: 0.9rem;
        padding: 0 1rem;
    }
</style>

<script>
    (function () {
        const overlay = document.getElementById('imageLightbox');
        const overlayImg = document.getElementById('imageLightboxImg');
        const overlayCaption = document.getElementById('imageLightboxCaption');
        const closeBtn = overlay.querySelector('.image-lightbox-close');

        window.openImageLightbox = function (src, caption) {
            if (!src) return;
            overlayImg.src = src;
            overlayImg.alt = caption || 'Preview';
            overlayCaption.textContent = caption || '';
            overlay.classList.add('is-open');
            overlay.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        };

        function closeLightbox() {
            overlay.classList.remove('is-open');
            overlay.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }

        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeLightbox();
        });
        closeBtn.addEventListener('click', closeLightbox);

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeLightbox();
        });

        // Event delegation: berlaku untuk foto yang sudah ada saat load
        // maupun yang dirender belakangan (misalnya hasil pencarian AJAX).
        document.addEventListener('click', function (e) {
            const imgTarget = e.target.closest('.zoomable-img');
            if (imgTarget) {
                const caption = imgTarget.dataset.caption || imgTarget.alt || '';
                window.openImageLightbox(imgTarget.currentSrc || imgTarget.src, caption);
                return;
            }

            const wrapTarget = e.target.closest('[data-zoomable-src]');
            if (wrapTarget) {
                const caption = wrapTarget.dataset.caption || '';
                window.openImageLightbox(wrapTarget.dataset.zoomableSrc, caption);
            }
        });
    })();
</script>
