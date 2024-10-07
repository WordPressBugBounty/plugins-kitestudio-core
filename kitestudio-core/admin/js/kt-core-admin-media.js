(function ($) {
  "use strict";

  $(function () {
    var typingTimer;
    var isLoading = false;
    var photosAjaxSearch = null;
    var isIsotopeActive = false;

    $("#kt-search-media").on("keyup", function () {
      if ($(this).val().length < 3) {
        return;
      }
      clearTimeout(typingTimer);
      typingTimer = setTimeout(searchPhotos, "2000");
    });

    $("#kt-search-media").on("keydown", function () {
      if ($(this).val().length < 3) {
        return;
      }
      if (!$(".kt-media-wrapper").hasClass("loading")) {
        $(".kt-media-wrapper").addClass("loading");
      }
      clearTimeout(typingTimer);
    });

    function searchPhotos(clear_results = true) {
      if (!$(".kt-media-wrapper").hasClass("loading")) {
        $(".kt-media-wrapper").addClass("loading");
      }

      var input = $("#kt-search-media");
      var pageNumber = $('input[name="page-number"]');
      if (clear_results) {
        pageNumber.val(1);
        if (isIsotopeActive) {
          $('.kt-photos').empty();
          $('.kt-photos').isotope('destroy');
        }
      }

      // If all result pages showed
      if (pageNumber.val() == 0) {
        return;
      }

      isLoading = true;
      if (photosAjaxSearch) {
        photosAjaxSearch.abort();
      }
      photosAjaxSearch = $.ajax({
        url: kitestudioCore.ajax_url,
        dataType: "json",
        type: "GET",
        cache: false,
        headers: { "cache-control": "no-cache" },
        data: {
          action: "search_kite_photos",
          s: input.val(),
          page: ( clear_results ? 1 : parseInt( pageNumber.val() ) + 1 ),
          nonce: $('input[name="nonce"]').val(),
        },
        success: function (response) {
          $('.kt-media-wrapper p').hide();
          if (response.success) {
            if (clear_results) {
              $(".media-results .kt-photos").html(response.data.markup);
              $(".kt-photos").isotope({
                itemSelector: ".kt-photo",
                layoutMode: "masonry",
                masonry: {
                  columnWidth: ".kt-photo",
                  gutter: 5,
                },
              });
            } else {
              var $markup = $(response.data.markup);
              $(".kt-photos")
                .append( $markup )
                .isotope("appended", $markup );
              if (response.data.total_pages - pageNumber.val() > 1) {
                pageNumber.val(parseInt(pageNumber.val()) + 1);
              } else {
                pageNumber.val(0);
              }
            }
            isIsotopeActive = true;
            $(".kt-media-wrapper").removeClass("loading");
            downloadPhoto();
          } else {
            $(".kt-media-wrapper").removeClass("loading");
            if (clear_results) {
              $(".media-results .kt-photos").html(response.data.message);
            } else {
              $(".media-results .kt-photos").append(response.data.message);
            }
          }
          isLoading = false;
        },
      });
    }

    function downloadPhoto() {
      $(".kt-photo .download").off("click");
      $(".kt-photo .download").on("click", function () {
        var $photo = $(this).parents('.kt-photo');
        $photo.addClass('downloading');
        $.ajax({
          url: kitestudioCore.ajax_url,
          dataType: "json",
          type: "GET",
          cache: false,
          headers: { "cache-control": "no-cache" },
          data: {
            action: "download_media",
            id: $(this).data("id"),
            nonce: $('input[name="nonce"]').val(),
          },
          success: function (response) {
            if (response.success) {
              $('.kt-toast').addClass('show');
              setTimeout(function () {
                $('.kt-toast').removeClass('show');
              }, '3000');
            }
            $photo.removeClass('downloading');
          },
        });
      });
    }

    window.addEventListener("scroll", function () {
      if ( ( document.documentElement.scrollHeight - document.body.scrollTop ) < 1000 ) {
        if (!isLoading) {
          searchPhotos(false);
        }
      }
    });
  });
})(jQuery);
