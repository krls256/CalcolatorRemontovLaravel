$(document).ready(function() { 
    $(document).on('click', '.reviews-delete', function(e) { 
        e.preventDefault();
        let $this   = $(this);
        let id      = $this.data('id');

        $.ajax({
            type: "POST", 
            cache: false,
            url: '/ajax/reviews/delete',
            data: { id: id }, 
            success: (e) => { 
                if(e.status == 'ok') { 
                    $this.closest('.review').remove();
                }
            }
        });
    });
});