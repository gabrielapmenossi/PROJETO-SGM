/**
 * Miniaturas de foto nas tabelas + modal compacto (Bootstrap 5).
 * Requer: bootstrap.bundle.min.js carregado antes deste arquivo.
 */
(function () {
    'use strict';

    function escAttr(s) {
        return String(s)
            .replace(/&/g, '&amp;')
            .replace(/"/g, '&quot;')
            .replace(/</g, '&lt;');
    }

    function urlFoto(caminho) {
        if (caminho == null) return '';
        var t = String(caminho).trim();
        if (!t) return '';
        if (/^https?:\/\//i.test(t)) return t;
        t = t.replace(/^\.\//, '');
        return './' + t;
    }

    function ensureModal() {
        if (document.getElementById('modalFotoChamado')) return;
        document.body.insertAdjacentHTML(
            'beforeend',
            '<div class="modal fade" id="modalFotoChamado" tabindex="-1" aria-hidden="true">' +
                '<div class="modal-dialog modal-dialog-centered chamado-foto-modal-dialog">' +
                '<div class="modal-content border-0 shadow">' +
                '<div class="modal-header py-2 px-3">' +
                '<h6 class="modal-title mb-0">Foto do chamado</h6>' +
                '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>' +
                '</div>' +
                '<div class="modal-body text-center p-2 bg-light">' +
                '<img src="" id="imgModalChamado" class="chamado-foto-modal-img img-fluid rounded" alt="">' +
                '</div>' +
                '</div></div></div>'
        );
        document.getElementById('modalFotoChamado').addEventListener('hidden.bs.modal', function () {
            var im = document.getElementById('imgModalChamado');
            if (im) im.removeAttribute('src');
        });
    }

    function abrirModalFoto(caminho) {
        var u = urlFoto(caminho);
        if (!u || typeof bootstrap === 'undefined') return;
        ensureModal();
        var img = document.getElementById('imgModalChamado');
        var modalEl = document.getElementById('modalFotoChamado');
        if (!img || !modalEl) return;
        img.src = u;
        img.onerror = function () {
            img.alt = 'Não foi possível carregar a imagem.';
            img.style.display = 'none';
        };
        img.onload = function () {
            img.style.display = '';
        };
        new bootstrap.Modal(modalEl).show();
    }

    document.addEventListener('click', function (e) {
        var trig = e.target.closest('[data-foto-modal]');
        if (!trig) return;
        e.preventDefault();
        var enc = trig.getAttribute('data-foto-modal');
        if (!enc) return;
        var raw;
        try {
            raw = decodeURIComponent(enc);
        } catch (err) {
            raw = enc;
        }
        abrirModalFoto(raw);
    });

    function celulaMiniatura(caminho) {
        var u = urlFoto(caminho);
        if (!u) {
            return (
                '<span class="chamado-sem-foto" title="Sem foto">' +
                '<i class="bi bi-image" aria-hidden="true"></i></span>'
            );
        }
        var enc = encodeURIComponent(u);
        return (
            '<button type="button" class="chamado-thumb-btn btn btn-link p-0 align-middle" ' +
            'data-foto-modal="' +
            enc +
            '" title="Ver foto">' +
            '<img src="' +
            escAttr(u) +
            '" class="chamado-table-thumb" alt="" loading="lazy" width="48" height="48">' +
            '</button>'
        );
    }

    window.ChamadoFotos = {
        urlFoto: urlFoto,
        celulaMiniatura: celulaMiniatura,
        abrirModalFoto: abrirModalFoto,
        ensureModal: ensureModal
    };
    window.verFoto = abrirModalFoto;

    function init() {
        ensureModal();
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
