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
                        <div class="main-user-information">
                            <h2>#${r.data.id}. ${r.data.name}'s details:</h2>
                            <p>
                                - Working at ${r.data.company.name}'s company.
                                </br>
                                <small>
                                    <u>Business slogan:</u> ${r.data.company.bs}
                                    </br>
                                    <u>Catch phrase:</u> ${r.data.company.catchPhrase}
                                </small>
                            </p>
                            <p>
                                - Lives in ${r.data.address.suite}, ${r.data.address.street},
                                    ${r.data.address.city}, with the postal code ${r.data.address.zipcode}.
                            </p>
                            </br>
                        </div>
                        <div class="other-user-info">
                            <h3>Other user's information:</h3>
                            <p><b>Username:</b> ${r.data.username}</p>
                            <p><b>Email:</b> ${r.data.email}</p>
                            <p><b>Website:</b> ${r.data.website}</p>
                            <p><b>Phone:</b> ${r.data.phone}</p>
                        </div>

                    `;
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