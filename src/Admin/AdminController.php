<?php

declare(strict_types=1);

namespace Frolyak\FrolyakIvanWpPlugin\Admin;

/**
 * Class AdminController
 */
class AdminController
{

    /**
     * AdminController constructor
     */
    public function __construct()
    {
        add_action('admin_menu', [$this, 'setAdminMenu']);
        add_action('admin_init', [$this, 'adminInit']);
    }

    /**
     * Adds a new page to the Admin menu.
     */
    public function setAdminMenu()
    {
        add_menu_page(
            'Frolyak Plugin Settings',
            'Frolyak Plugin Settings',
            'manage_options',
            'frolyak_settings',
            [$this, 'setSettingPage']
        );
    }

    /**
     * Creates a Setting page.
     */
    public function setSettingPage()
    {
        ?>
        <div class="wrap">
            <h1>Frolyak Ivan WP Plugin Settings</h1>
            <form method="post" action="options.php">
                <?php
                    settings_fields('frolyak_ivan_wp_options');
                    do_settings_sections('frolyak_ivan_wp_options');
                    submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Sanitizes and validates entered value by user.

     * @return string
     */
    public function sanitizeEndpointValue($value)
    {
        $value = sanitize_text_field($value);
        $value = sanitize_title($value);

        return $value ?: 'custom-endpoint';
    }

    /**
     * Initializes the admin page settings, sections and fields...
     */
    public function adminInit()
    {
        register_setting(
            'frolyak_ivan_wp_options',
            'frolyak_ivan_custom_endpoint',
            [
                'sanitize_callback' =>  [$this, 'sanitizeEndpointValue']
            ]
        );

        add_settings_section(
            'frolyak_plugin_section',
            'Custom Settings',
            function() {
                echo 'Set your custom endpoint:';
            },
            'frolyak_ivan_wp_options'
        );

        add_settings_field(
            'frolyak_ivan_custom_endpoint',
            'Custom Endpoint',
            function()
            {
                $options = get_option('frolyak_ivan_custom_endpoint', 'custom-endpoint');

                ?>
                    <input
                        type="text"
                        name="frolyak_ivan_custom_endpoint"
                        value=""
                        placeholder="Introduce your endpoint"
                    />
                    </br>
                    <small>
                        Current endpoint value is:
                            <a href="<?= site_url()."/$options" ?>" target="_blank">
                                /<u><?= $options; ?></u>
                            </a>
                    </small>
                <?php
            },
            'frolyak_ivan_wp_options',
            'frolyak_plugin_section'
        );
    }
}
