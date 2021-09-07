<?php

namespace OXI_IMAGE_HOVER_PLUGINS\Classes;

/**
 * Description of Image Hover Rest API
 *
 * @author $biplob018
 */
class ImageApi {

    /**
     * Define $wpdb
     *
     * @since 9.3.0
     */
    public $wpdb;

    /**
     * Database Parent Table
     *
     * @since 9.3.0
     */
    public $parent_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $import_table;

    /**
     * Database Import Table
     *
     * @since 9.3.0
     */
    public $child_table;
    public $request;
    public $rawdata;
    public $styleid;
    public $childid;

    const API = 'https://www.image-hover.oxilab.org/wp-json/imagehoverultimate/v2/';

    /**
     * Constructor of plugin class
     *
     * @since 9.3.0
     */
    public function __construct() {
        global $wpdb;
        $this->wpdb = $wpdb;
        $this->parent_table = $this->wpdb->prefix . 'image_hover_ultimate_style';
        $this->child_table = $this->wpdb->prefix . 'image_hover_ultimate_list';
        $this->import_table = $this->wpdb->prefix . 'oxi_div_import';
        $this->build_api();
    }

    public function build_api() {
        add_action('rest_api_init', function () {
            register_rest_route(untrailingslashit('ImageHoverUltimate/v1/'), '/(?P<action>\w+)/', array(
                'methods' => array('GET', 'POST'),
                'callback' => [$this, 'api_action'],
                'permission_callback' => '__return_true'
            ));
        });
    }

    public function api_action($request) {
        $this->request = $request;
        $this->rawdata = addslashes($request['rawdata']);
        $this->styleid = $request['styleid'];
        $this->childid = $request['childid'];
        $class = $request['class'];
        $action_class = strtolower($request->get_method()) . '_' . sanitize_key($request['action']);
        if ($class != ''):
            $args = $request['args'];
            $optional = $request['optional'];
            ob_start();
            $CLASS = new $class;
            $CLASS->__construct($request['action'], $this->rawdata, $args, $optional);
            return ob_get_clean();
        else:
            if (method_exists($this, $action_class)) {
                return $this->{$action_class}();
            }
        endif;
    }

    public function array_replace($arr = [], $search = '', $replace = '') {
        array_walk($arr, function (&$v) use ($search, $replace) {
            $v = str_replace($search, $replace, $v);
        });
        return $arr;
    }

    public function post_create_new() {
        if (!empty($this->styleid)):
            $styleid = (int) $this->styleid;
            $newdata = $this->wpdb->get_row($this->wpdb->prepare('SELECT * FROM ' . $this->parent_table . ' WHERE id = %d ', $styleid), ARRAY_A);
            $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->parent_table} (name, style_name, rawdata) VALUES ( %s, %s, %s)", array($data, $newdata['style_name'], $newdata['rawdata'])));
            $redirect_id = $this->wpdb->insert_id;
            if ($redirect_id > 0):
                $raw = json_decode(stripslashes($newdata['rawdata']), true);
                $raw['image-hover-style-id'] = $redirect_id;
                $s = explode('-', $newdata['style_name']);
                $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
                $C = new $CLASS('admin');
                $f = $C->template_css_render($raw);
                $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $styleid), ARRAY_A);
                foreach ($child as $value) {
                    $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d, %s)", array($redirect_id, $value['rawdata'])));
                }
                return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id");
            endif;
        else:
            $params = json_decode(stripslashes($this->rawdata), true);
            $newname = $params['name'];
            $rawdata = $params['style'];
            $style = $rawdata['style'];
            $child = $rawdata['child'];
            $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->parent_table} (name, style_name, rawdata) VALUES ( %s, %s, %s)", array($newname, $style['style_name'], $style['rawdata'])));
            $redirect_id = $this->wpdb->insert_id;
            if ($redirect_id > 0):
                $raw = json_decode(stripslashes($style['rawdata']), true);
                $raw['image-hover-style-id'] = $redirect_id;
                $s = explode('-', $style['style_name']);
                $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
                $C = new $CLASS('admin');
                $f = $C->template_css_render($raw);
                foreach ($child as $value) {
                    $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d,  %s)", array($redirect_id, $value['rawdata'])));
                }
                return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id");
            endif;
        endif;
    }

    public function post_json_import($folder, $filename) {
        if (is_file($folder . $filename)) {
            $this->rawdata = file_get_contents($folder . $filename);
            $params = json_decode($this->rawdata, true);
            $style = $params['style'];
            $child = $params['child'];
            $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->parent_table} (name, style_name, rawdata) VALUES ( %s, %s, %s)", array($style['name'], $style['style_name'], $style['rawdata'])));
            $redirect_id = $this->wpdb->insert_id;
            if ($redirect_id > 0):
                $raw = json_decode(stripslashes($style['rawdata']), true);
                $raw['image-hover-style-id'] = $redirect_id;
                $s = explode('-', $style['style_name']);
                $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
                $C = new $CLASS('admin');
                $f = $C->template_css_render($raw);
                foreach ($child as $value) {
                    $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d,  %s)", array($redirect_id, $value['rawdata'])));
                }
                return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id");
            endif;
        }
    }

    public function post_shortcode_delete() {
        $styleid = (int) $this->styleid;
        if ($styleid):
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->parent_table} WHERE id = %d", $styleid));
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->child_table} WHERE styleid = %d", $styleid));
            return 'done';
        else:
            return 'Silence is Golden';
        endif;
    }

    public function update_image_hover_plugin() {
        $stylelist = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->parent_table ORDER by id ASC"), ARRAY_A);
        foreach ($stylelist as $value) {
            $raw = json_decode(stripslashes($value['rawdata']), true);
            $raw['image-hover-style-id'] = $value['id'];
            $s = explode('-', $value['style_name']);
            $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
            $C = new $CLASS('admin');
            $f = $C->template_css_render($raw);
        }
        update_option('image_hover_ultimate_update_complete', 'done');
    }

    /**
     * Generate safe path
     * @since v1.0.0
     */
    public function safe_path($path) {

        $path = str_replace(['//', '\\\\'], ['/', '\\'], $path);
        return str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);
    }

    public function get_shortcode_export() {
        $styleid = (int) $this->styleid;
        if ($styleid):
            $style = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $this->parent_table WHERE id = %d", $styleid), ARRAY_A);
            $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $styleid), ARRAY_A);
            $filename = 'image-hover-effects-ultimateand' . $style['id'] . '.json';
            $files = [
                'style' => $style,
                'child' => $child,
            ];
            $finalfiles = json_encode($files);
            $this->send_file_headers($filename, strlen($finalfiles));
            @ob_end_clean();
            flush();
            echo $finalfiles;
            die;
        else:
            return 'Silence is Golden';
        endif;
    }

    /**
     * Send file headers.
     *
     *
     * @param string $file_name File name.
     * @param int    $file_size File size.
     */
    private function send_file_headers($file_name, $file_size) {
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . $file_name);
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $file_size);
    }

    public function post_shortcode_deactive() {
        $id = $this->rawdata . '-' . (int) $this->styleid;
        $effects = $this->rawdata . '-ultimate';
        if ($this->styleid > 0):
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->import_table} WHERE name = %s and type = %s", $id, $effects));
            return 'done';
        else:
            return 'Silence is Golden';
        endif;
    }

    public function post_shortcode_active() {
        $id = $this->rawdata . '-' . (int) $this->styleid;
        $effects = $this->rawdata . '-ultimate';
        if ($this->styleid > 0):
            $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->import_table} (type, name) VALUES (%s, %s)", array($effects, $id)));
            return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$this->rawdata#" . $id);
        else:
            return 'Silence is Golden';
        endif;
    }

    /**
     * Template Style Data
     *
     * @since 9.3.0
     */
    public function post_elements_template_style() {
        $settings = json_decode(stripslashes($this->rawdata), true);
        $StyleName = sanitize_text_field($settings['image-hover-template']);
        $stylesheet = '';
        if ((int) $this->styleid):
            $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->parent_table} SET rawdata = %s, stylesheet = %s WHERE id = %d", $this->rawdata, $stylesheet, $this->styleid));
            $name = explode('-', $StyleName);
            $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . $name[0] . '\Admin\Effects' . $name[1];
            $CLASS = new $cls('admin');
            return $CLASS->template_css_render($settings);
        endif;
    }

    /**
     * Template Style Data
     *
     * @since 9.3.0
     */
    public function post_template_change() {
        $rawdata = sanitize_text_field($this->rawdata);
        if ((int) $this->styleid):
            $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->parent_table} SET style_name = %s WHERE id = %d", $rawdata, $this->styleid));
        endif;
        return 'success';
    }

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function post_template_name() {
        $settings = json_decode(stripslashes($this->rawdata), true);
        $name = sanitize_text_field($settings['addonsstylename']);
        $id = $settings['addonsstylenameid'];
        if ((int) $id):
            $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->parent_table} SET name = %s WHERE id = %d", $name, $id));
            return 'success';
        endif;
    }

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function post_elements_rearrange_modal_data() {
        if ((int) $this->styleid):
            $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $this->styleid), ARRAY_A);
            $render = [];
            foreach ($child as $k => $value) {
                $data = json_decode(stripcslashes($value['rawdata']));
                $render[$value['id']] = $data;
            }
            return json_encode($render);
        endif;
    }

    /**
     * Template Name Change
     *
     * @since 9.3.0
     */
    public function post_elements_template_rearrange_save_data() {
        $params = explode(',', $this->rawdata);
        foreach ($params as $value) {
            if ((int) $value):
                $data = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE id = %d ", $value), ARRAY_A);
                $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d, %s)", array($data['styleid'], $data['rawdata'])));
                $redirect_id = $this->wpdb->insert_id;
                if ($redirect_id == 0) {
                    return;
                }
                if ($redirect_id != 0) {
                    $this->wpdb->query($this->wpdb->prepare("DELETE FROM $this->child_table WHERE id = %d", $value));
                }
            endif;
        }
        return 'success';
    }

    /**
     * Template Modal Data
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data() {
        if ((int) $this->styleid):
            if ((int) $this->childid):
                $this->wpdb->query($this->wpdb->prepare("UPDATE {$this->child_table} SET rawdata = %s WHERE id = %d", $this->rawdata, $this->childid));
            else:
                $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d, %s )", array($this->styleid, $this->rawdata)));
            endif;
        endif;
        return 'success';
    }

    /**
     * Template Rebuild Render
     *
     * @since 9.3.0
     */
    public function post_elements_template_rebuild_data() {
        $style = $this->wpdb->get_row($this->wpdb->prepare('SELECT * FROM ' . $this->parent_table . ' WHERE id = %d ', $this->styleid), ARRAY_A);
        $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $this->styleid), ARRAY_A);
        $style['rawdata'] = $style['stylesheet'] = $style['font_family'] = '';
        $name = explode('-', $style['style_name']);
        $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($name[0]) . '\Render\Effects' . $name[1];
        $CLASS = new $cls;
        $CLASS->__construct($style, $child, 'admin');
        return 'success';
    }

    /**
     * Template Template Render
     *
     * @since 9.3.0
     */
    public function post_elements_template_render_data() {
        $settings = json_decode(stripslashes($this->rawdata), true);
        $child = $this->wpdb->get_results($this->wpdb->prepare("SELECT * FROM $this->child_table WHERE styleid = %d ORDER by id ASC", $this->styleid), ARRAY_A);
        $StyleName = $settings['image-hover-template'];
        $name = explode('-', $StyleName);
        ob_start();
        $cls = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . $name[0] . '\Render\Effects' . $name[1];
        $CLASS = new $cls;
        $styledata = ['rawdata' => $this->rawdata, 'id' => $this->styleid, 'style_name' => $StyleName, 'stylesheet' => ''];
        $CLASS->__construct($styledata, $child, 'admin');
        return ob_get_clean();
    }

    /**
     * Template Modal Data Edit Form
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data_edit() {
        if ((int) $this->childid):
            $listdata = $this->wpdb->get_row($this->wpdb->prepare("SELECT * FROM {$this->child_table} WHERE id = %d ", $this->childid), ARRAY_A);
            $returnfile = json_decode(stripslashes($listdata['rawdata']), true);
            $returnfile['shortcodeitemid'] = $this->childid;
            return json_encode($returnfile);
        else:
            return 'Silence is Golden';
        endif;
    }

    /**
     * Template Child Delete Data
     *
     * @since 9.3.0
     */
    public function post_elements_template_modal_data_delete() {
        if ((int) $this->childid):
            $this->wpdb->query($this->wpdb->prepare("DELETE FROM {$this->child_table} WHERE id = %d ", $this->childid));
            return 'done';
        else:
            return 'Silence is Golden';
        endif;
    }

    /**
     * Admin Notice API  loader
     * @return void
     */
    public function post_oxi_recommended() {
        $data = 'done';
        update_option('oxi_image_hover_recommended', $data);
        return $data;
    }

    /**
     * Admin Notice Recommended  loader
     * @return void
     */
    public function post_notice_dissmiss() {
        $notice = $this->request['notice'];
        if ($notice == 'maybe'):
            $data = strtotime("now");
            update_option('oxi_image_hover_activation_date', $data);
        else:
            update_option('oxi_image_hover_nobug', $notice);
        endif;
        return $notice;
    }

    /**
     * Admin Settings
     * @return void
     */
    public function post_oxi_settings() {
        $rawdata = json_decode(stripslashes($this->rawdata), true);
        update_option($rawdata['name'], $rawdata['value']);
        return '<span class="oxi-confirmation-success"></span>';
    }

    /**
     * Admin License
     * @return void
     */
    public function post_oxi_license() {
        $rawdata = json_decode(stripslashes($this->rawdata), true);
        $new = $rawdata['license'];
        $old = get_option('image_hover_ultimate_license_key');
        $status = get_option('image_hover_ultimate_license_status');
        if ($new == ''):
            if ($old != '' && $status == 'valid'):
                $this->deactivate_license($old);
            endif;
            delete_option('image_hover_ultimate_license_key');
            $data = ['massage' => '<span class="oxi-confirmation-blank"></span>', 'text' => ''];
        else:
            update_option('image_hover_ultimate_license_key', $new);
            delete_option('image_hover_ultimate_license_status');
            $r = $this->activate_license($new);
            if ($r == 'success'):
                $data = ['massage' => '<span class="oxi-confirmation-success"></span>', 'text' => 'Active'];
            else:
                $data = ['massage' => '<span class="oxi-confirmation-failed"></span>', 'text' => $r];
            endif;
        endif;
        return $data;
    }

    public function activate_license($key) {
        $api_params = array(
            'edd_action' => 'activate_license',
            'license' => $key,
            'item_name' => urlencode('Image Hover Effects Ultimate'),
            'url' => home_url()
        );

        $response = wp_remote_post('https://www.oxilab.org', array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));

        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {
            if (is_wp_error($response)) {
                $message = $response->get_error_message();
            } else {
                $message = __('An error occurred, please try again.');
            }
        } else {
            $license_data = json_decode(wp_remote_retrieve_body($response));

            if (false === $license_data->success) {

                switch ($license_data->error) {

                    case 'expired' :

                        $message = sprintf(
                                __('Your license key expired on %s.'), date_i18n(get_option('date_format'), strtotime($license_data->expires, current_time('timestamp')))
                        );
                        break;

                    case 'revoked' :

                        $message = __('Your license key has been disabled.');
                        break;

                    case 'missing' :

                        $message = __('Invalid license.');
                        break;

                    case 'invalid' :
                    case 'site_inactive' :

                        $message = __('Your license is not active for this URL.');
                        break;

                    case 'item_name_mismatch' :

                        $message = sprintf(__('This appears to be an invalid license key for %s.'), OXI_IMAGE_HOVER_TEXTDOMAIN);
                        break;

                    case 'no_activations_left':

                        $message = __('Your license key has reached its activation limit.');
                        break;

                    default :

                        $message = __('An error occurred, please try again.');
                        break;
                }
            }
        }

        if (!empty($message)) {
            return $message;
        }
        update_option('image_hover_ultimate_license_status', $license_data->license);
        return 'success';
    }

    public function deactivate_license($key) {
        $api_params = array(
            'edd_action' => 'deactivate_license',
            'license' => $key,
            'item_name' => urlencode('Image Hover Effects Ultimate'),
            'url' => home_url()
        );
        $response = wp_remote_post('https://www.oxilab.org', array('timeout' => 15, 'sslverify' => false, 'body' => $api_params));
        if (is_wp_error($response) || 200 !== wp_remote_retrieve_response_code($response)) {

            if (is_wp_error($response)) {
                $message = $response->get_error_message();
            } else {
                $message = __('An error occurred, please try again.');
            }
            return $message;
        }
        $license_data = json_decode(wp_remote_retrieve_body($response));
        if ($license_data->license == 'deactivated') {
            delete_option('image_hover_ultimate_license_status');
            delete_option('image_hover_ultimate_license_key');
        }
        return 'success';
    }

    public static function instance() {
        if (self::$instance == null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function fixed_data($agr) {
        return hex2bin($agr);
    }

    public function post_web_template() {

        $folder = $this->safe_path(OXI_IMAGE_HOVER_PATH . 'template/');
        if (!is_dir($folder)):
            mkdir($folder, 0777);
        endif;
        $files = OXI_IMAGE_HOVER_PATH . 'template/' . $this->rawdata . '-' . $this->styleid . '.json';
        if (!file_exists($files)):
            $this->download_web_files($files);
        endif;
        $template_data = json_decode(file_get_contents($files), true);

        $render = '';
        $vs = get_option($this->fixed_data('696d6167655f686f7665725f756c74696d6174655f6c6963656e73655f737461747573'));
        foreach ($template_data as $key => $value) {
            if ($vs == $this->fixed_data('76616c6964')) {
                $button = '<button type="button" class="btn btn-success oxi-addons-addons-web-template-import-button" web-data="' . $value['style']['style_name'] . '" web-template="' . $value['style']['id'] . '">Import</button>';
            } else {
                $button = '<button class="btn btn-warning oxi-addons-addons-style-btn-warning" title="Pro Only" type="submit" value="pro only" name="addonsstyleproonly">Pro Only</button>';
            }
            $render .= '<div class="oxi-addons-col-1">
                                    <div class="oxi-addons-style-preview">
                                        <div class="oxi-addons-style-preview-top oxi-addons-center">';
            $C = '\OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($this->rawdata) . '\Render\Effects' . $this->styleid;

            ob_start();
            if (class_exists($C)):
                new $C($value['style'], $value['child'], 'web');
            endif;
            $render .= ob_get_contents();
            ob_end_clean();

            $render .= '                </div>
                                        <div class="oxi-addons-style-preview-bottom">
                                            <div class="oxi-addons-style-preview-bottom-left">
                                                ' . $value['style']['name'] . '                      
                                            </div>
                                            <div class="oxi-addons-style-preview-bottom-right">
                                                ' . $button . '
                                            </div>
                                        </div>
                                    </div>
                                </div>';
        }
        return $render;
    }

    public function download_web_files($files) {


        $URL = self::API . $this->rawdata . '/' . $this->styleid;
        $request = wp_remote_request($URL);
        if (!is_wp_error($request)) {
            $response = json_decode(wp_remote_retrieve_body($request), true);
        } else {
            return $request->get_error_message();
        }

        $data = json_decode($response, true);
        if (file_put_contents($files, json_encode($data))) {
            
        }
    }

    public function post_web_import() {
        $files = OXI_IMAGE_HOVER_PATH . 'template/' . $this->rawdata . '.json';
        $params = json_decode(file_get_contents($files), true)[$this->styleid];

        $style = $params['style'];
        $child = $params['child'];
        $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->parent_table} (name, style_name, rawdata) VALUES ( %s, %s, %s)", array($style['name'], $style['style_name'], $style['rawdata'])));
        $redirect_id = $this->wpdb->insert_id;
        if ($redirect_id > 0):
            $raw = json_decode(stripslashes($style['rawdata']), true);
            $raw['image-hover-style-id'] = $redirect_id;
            $s = explode('-', $style['style_name']);
            $CLASS = 'OXI_IMAGE_HOVER_PLUGINS\Modules\\' . ucfirst($s[0]) . '\Admin\Effects' . $s[1];
            $C = new $CLASS('admin');
            $f = $C->template_css_render($raw);
            foreach ($child as $value) {
                $this->wpdb->query($this->wpdb->prepare("INSERT INTO {$this->child_table} (styleid, rawdata) VALUES (%d,  %s)", array($redirect_id, $value['rawdata'])));
            }
            return admin_url("admin.php?page=oxi-image-hover-ultimate&effects=$s[0]&styleid=$redirect_id");
        endif;
        
    }

}
