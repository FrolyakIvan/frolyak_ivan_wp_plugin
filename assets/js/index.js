jQuery(document).ready(function($) {
    $('.user-details').on('click', function() {
        var userId = $(this).data('userid');

        if (userId) getUser(+userId);
    });

    function getUser(id) {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'get_users_details',
                userId: id
            },
            success: function (r) {
                if (r?.success) {
                    var detalles = `
                        <h3>User details:</h3>
                        <p><b>ID:</b> ${r.data.id}</p>
                        <p><b>Name:</b> ${r.data.name}</p>
                        <p><b>Username:</b> ${r.data.username}</p>
                        <p><b>Email:</b> ${r.data.email}</p>
                        <p><b>Website:</b> ${r.data.website}</p>
                        <p><b>Phone:</b> ${r.data.phone}</p>
                    `;
                    // TODO: Add the rest user information (address, company)
                    $('#user-details').html(detalles);
                }
            },
            error: function (e) {

                e = e.responseJSON;
                if (!e.success) alert(`${e.data.message || 'An error ocurred in the server-side...'}`);
            }
        });
    }
})