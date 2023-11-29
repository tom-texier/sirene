import {$} from "./main";

export function init()
{
    let $form = $('#search-form');
    let $resultsContainer = $('#results-container');

    if(!$form.length || !$resultsContainer.length) return;

    // Form Submit
    $form.on('submit', function(e) {
        e.preventDefault();
        callSearchAjax();
    })

    // Close modal button
    $('#details-modal button.close-button').on('click', function(e) {
        e.preventDefault();
        $('#details-modal').fadeOut(200);
    })

    // Limit selector
    $resultsContainer.find('.results__top .configuration select').on('change', function(e) {
        e.preventDefault();

        if($form.find('#search_query').val() !== '') {
            callSearchAjax();
        }
    })

    initEvents();
}

function initEvents()
{
    $('#results-container .results__list a.get_details:not(.initialized)').on('click', function(e) {
        e.preventDefault();

        let siret = $(this).data('siret');

        if(siret) {
            callDetailsAjax(siret);
        }
    })

    $('#results-container .results__list a.get_details:not(.initialized)').addClass('initialized');

    $('#results-container .results__navigation a:not(.initialized)').on('click', function(e) {
        e.preventDefault();

        let nextPage = $(this).data('next-page');

        if(nextPage) {
            callSearchAjax(nextPage, true);
        }
    })

    $('#results-container .results__navigation a:not(.initialized)').addClass('initialized');
}

function callSearchAjax(page = 1, isLoadMore = false)
{
    let $form = $('#search-form');
    let $resultsContainer = $('#results-container');
    let $loader = $resultsContainer.find('.results__loader');
    let term = $form.find('#search_query').val();
    let limit = $resultsContainer.find('.results__top .configuration select option:selected').val();

    $loader.fadeIn(100);

    $.get(`/api/search/${term}`, {page, limit})
        .done(function(result) {
            $.each(result, function(selector, content) {
                if(isLoadMore && selector === "results__list") {
                    $resultsContainer.find(`.${selector}`).append(content);
                }
                else {
                    $resultsContainer.find(`.${selector}`).html(content);
                }
            })
            initEvents();
        })
        .fail(function(result) {
            showError(result.responseJSON.message ?? "Une erreur est survenue");
        })
        .always(function() {
            $loader.fadeOut(100);
        })
}

function callDetailsAjax(siret)
{
    let $detailsModal = $('#details-modal');
    let $loader = $detailsModal.find('.modal__content .modal__loader');

    $detailsModal.find('.modal__infos').html("");
    $loader.show();
    $detailsModal.fadeIn(200);

    $.get(`/api/show/${siret}`)
        .done(function(result) {
            $.each(result, function(selector, content) {
                $detailsModal.find(`.${selector}`).html(content);
            })
        })
        .fail(function(result) {
            showError(result.message ?? "Une erreur est survenue");
        })
        .always(function() {
            $loader.fadeOut(100);
        })
}

function showError(message)
{
    let $detailsModal = $('#details-modal');
    let $loader = $detailsModal.find('.modal__content .modal__loader');
    $detailsModal.find('.modal__infos').text(message);
    $loader.hide();
    $detailsModal.fadeIn(200);
}