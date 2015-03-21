<?php

class Grocery_CRUD_CS extends Grocery_CRUD {

    protected $field_style = array(); //add by admin
    protected $default_value = array(); //add by admin

    public function get_field_types() {
        if ($this->field_types !== null) {
            return $this->field_types;
        }

        $types = array();
        foreach ($this->basic_model->get_field_types_basic_table() as $field_info) {
            $field_info->required = !empty($this->required_fields) && in_array($field_info->name, $this->required_fields) ? true : false;

            $field_info->display_as = isset($this->display_as[$field_info->name]) ?
                    $this->display_as[$field_info->name] :
                    ucfirst(str_replace("_", " ", $field_info->name));

            $field_info->style = (
                    isset($this->field_style[$field_info->name]) ?
                            $this->field_style[$field_info->name] : array()
                    );

            $field_info->default_value = (
                    isset($this->default_value[$field_info->name]) ?
                            $this->default_value[$field_info->name] : ""
                    );

            if ($this->change_field_type !== null && isset($this->change_field_type[$field_info->name])) {
                $field_type = $this->change_field_type[$field_info->name];

                if (isset($this->relation[$field_info->name])) {
                    $field_info->crud_type = "relation_" . $field_type->type;
                } elseif (isset($this->upload_fields[$field_info->name])) {
                    $field_info->crud_type = "upload_file_" . $field_type->type;
                } else {
                    $field_info->crud_type = $field_type->type;
                    $field_info->extras = $field_type->extras;
                }

                $real_type = $field_info->crud_type;
            } elseif (isset($this->relation[$field_info->name])) {
                $real_type = 'relation';
                $field_info->crud_type = 'relation';
            } elseif (isset($this->upload_fields[$field_info->name])) {
                $real_type = 'upload_file';
                $field_info->crud_type = 'upload_file';
            } else {
                $real_type = $this->get_type($field_info);
                $field_info->crud_type = $real_type;
            }

            switch ($real_type) {
                case 'text':
                    if (!empty($this->unset_texteditor) && in_array($field_info->name, $this->unset_texteditor))
                        $field_info->extras = false;
                    else
                        $field_info->extras = 'text_editor';
                    break;

                case 'relation':
                case 'relation_readonly':
                    $field_info->extras = $this->relation[$field_info->name];
                    break;

                case 'upload_file':
                case 'upload_file_readonly':
                    $field_info->extras = $this->upload_fields[$field_info->name];
                    break;

                default:
                    if (empty($field_info->extras))
                        $field_info->extras = false;
                    break;
            }

            $types[$field_info->name] = $field_info;
        }

        if (!empty($this->relation_n_n)) {
            foreach ($this->relation_n_n as $field_name => $field_extras) {
                $is_read_only = $this->change_field_type !== null && isset($this->change_field_type[$field_name]) && $this->change_field_type[$field_name]->type == 'readonly' ? true : false;
                $field_info = (object) array();
                $field_info->name = $field_name;
                $field_info->crud_type = $is_read_only ? 'readonly' : 'relation_n_n';
                $field_info->extras = $field_extras;
                $field_info->required = !empty($this->required_fields) && in_array($field_name, $this->required_fields) ? true : false;
                ;
                $field_info->display_as = isset($this->display_as[$field_name]) ?
                        $this->display_as[$field_name] :
                        ucfirst(str_replace("_", " ", $field_name));

                $types[$field_name] = $field_info;
            }
        }

        if (!empty($this->add_fields))
            foreach ($this->add_fields as $field_object) {
                $field_name = isset($field_object->field_name) ? $field_object->field_name : $field_object;

                if (!isset($types[$field_name])) {//Doesn't exist in the database? Create it for the CRUD
                    $extras = false;
                    if ($this->change_field_type !== null && isset($this->change_field_type[$field_name])) {
                        $field_type = $this->change_field_type[$field_name];
                        $extras = $field_type->extras;
                    }

                    $field_info = (object) array(
                                'name' => $field_name,
                                'crud_type' => $this->change_field_type !== null && isset($this->change_field_type[$field_name]) ?
                                        $this->change_field_type[$field_name]->type :
                                        'string',
                                'display_as' => isset($this->display_as[$field_name]) ?
                                        $this->display_as[$field_name] :
                                        ucfirst(str_replace("_", " ", $field_name)),
                                'required' => in_array($field_name, $this->required_fields) ? true : false,
                                'extras' => $extras
                    );

                    $types[$field_name] = $field_info;
                }
            }

        if (!empty($this->edit_fields))
            foreach ($this->edit_fields as $field_object) {
                $field_name = isset($field_object->field_name) ? $field_object->field_name : $field_object;

                if (!isset($types[$field_name])) {//Doesn't exist in the database? Create it for the CRUD
                    $extras = false;
                    if ($this->change_field_type !== null && isset($this->change_field_type[$field_name])) {
                        $field_type = $this->change_field_type[$field_name];
                        $extras = $field_type->extras;
                    }

                    $field_info = (object) array(
                                'name' => $field_name,
                                'crud_type' => $this->change_field_type !== null && isset($this->change_field_type[$field_name]) ?
                                        $this->change_field_type[$field_name]->type :
                                        'string',
                                'display_as' => isset($this->display_as[$field_name]) ?
                                        $this->display_as[$field_name] :
                                        ucfirst(str_replace("_", " ", $field_name)),
                                'required' => in_array($field_name, $this->required_fields) ? true : false,
                                'extras' => $extras
                    );

                    $types[$field_name] = $field_info;
                }
            }

        $this->field_types = $types;

        return $this->field_types;
    }

    protected function get_integer_input($field_info, $value) {
        $this->set_js_lib($this->default_javascript_path . '/jquery_plugins/jquery.numeric.min.js');
        $this->set_js_config($this->default_javascript_path . '/jquery_plugins/config/jquery.numeric.config.js');

        $styleStr = " style='";
        if (isset($field_info->style)) {
            $styles = $field_info->style;
            if (is_array($styles)) {
                foreach ($styles as $key => $val) {
                    $styleStr .= $key . ": " . $val . "; ";
                }
            } else {
                $styleStr .= $styles;
            }
        }
        // add by admin
        $styleStr .= "' ";

        $extra_attributes = '';
        if (!empty($field_info->db_max_length))
            $extra_attributes .= "maxlength='{$field_info->db_max_length}'";
        $input = "<input id='field-{$field_info->name}' name='{$field_info->name}' type='text' value='$value' class='numeric' $extra_attributes $styleStr />";
        return $input;
    }

    protected function get_readonly_input($field_info, $value)
    {
        $read_only_value = "";

        if (!empty($value) && !is_array($value)) {
            $read_only_value = $value;
        } elseif (is_array($value)) {
            $all_values = array_values($value);
            $read_only_value = implode(", ",$all_values);
        }

        $read_only_value = ($read_only_value == ""  && isset($field_info->default_value) ? $field_info->default_value : $read_only_value);
                
        return '<div id="field-'.$field_info->name.'" class="readonly_label">'.$read_only_value.'</div>';
    }
        
    protected function get_string_input($field_info, $value) {
        $value = !is_string($value) ? '' : str_replace('"', "&quot;", $value);

        $styleStr = " style='";
        if (isset($field_info->style)) {
            $styles = $field_info->style;
            if (is_array($styles)) {
                foreach ($styles as $key => $val) {
                    $styleStr .= $key . ": " . $val . "; ";
                }
            } else {
                $styleStr .= $styles;
            }
        }
        // add by admin
        $styleStr .= "' ";

        $extra_attributes = '';
        if (!empty($field_info->db_max_length))
            $extra_attributes .= "maxlength='{$field_info->db_max_length}'";
        $input = "<input id='field-{$field_info->name}' name='{$field_info->name}' type='text' value=\"$value\" $extra_attributes $styleStr/>";
        return $input;
    }

    protected function get_password_input($field_info, $value) {
        $value = "";
        if (isset($field_info->default_value)) {
            $value = $field_info->default_value;
        } else {
            $value = !is_string($value) ? '' : $value;
        }
        $styleStr = " style='";
        if (isset($field_info->style)) {
            $styles = $field_info->style;
            if (is_array($styles)) {
                foreach ($styles as $key => $val) {
                    $styleStr .= $key . ": " . $val . "; ";
                }
            } else {
                $styleStr .= $styles;
            }
        }
        // add by admin
        $styleStr .= "' ";

        $extra_attributes = '';
        if (!empty($field_info->db_max_length))
            $extra_attributes .= "maxlength='{$field_info->db_max_length}'";
        $input = "<input id='field-{$field_info->name}' name='{$field_info->name}' type='password' value='$value' $extra_attributes $styleStr/>";
        return $input;
    }

    function set_rules($field, $label = '', $rules = '') {

        if (is_string($field)) {
            $this->validation_rules[$field] = array('field' => $field, 'label' => $label, 'rules' => $rules);
        } elseif (is_array($field)) {
            foreach ($field as $num_field => $field_array) {
                if (isset($field_array['field'])) {
                    $this->validation_rules[$field_array['field']] = $field_array;
                } else {
                    $display_as = $field_array;
                    if (isset($this->display_as[$field_array])) {
                        $display_as = $this->display_as[$field_array];
                    }
                    $this->validation_rules[$field_array] = array('field' => $field_array, 'label' => $display_as, 'rules' => $rules);
                }
            }
        }
        return $this;
    }

    /**
     *
     * Just an alias to the change_field_type method
     * @param string $field
     * @param string $type
     * @param array|string $extras
     */
    public function field_style($field, $width = null) {
        if (is_array($field)) {
            foreach ($field as $value) {
                $this->field_style[$value] = $width;
            }
        } else {
            $this->field_style[$field] = $width;
        }

        return $this;
    }

    public function field_type($field, $type, $extras = null, $default_value = null) {
        if (is_array($field)) {
            foreach ($field as $value) {
                $this->default_value[$value] = $default_value;
            }
        } else {
            $this->default_value[$field] = $default_value;
        }

        return $this->change_field_type($field, $type, $extras);
    }

    public function get_form_validation() {
        if ($this->form_validation === null) {
            $this->form_validation = new grocery_CRUD_Form_validation();
            $ci = &get_instance();
            $ci->load->library('form_validation');
            $ci->form_validation = $this->form_validation;
        }
        return $this->form_validation;
    }

    // add by admin เรื่อง year
    protected function get_year_input($field_info, $value) {
        $this->set_css($this->default_css_path . '/ui/simple/' . grocery_CRUD::JQUERY_UI_CSS);
        $this->set_js_lib($this->default_javascript_path . '/jquery_plugins/ui/' . grocery_CRUD::JQUERY_UI_JS);

        if ($this->language !== 'english') {
            include($this->default_config_path . '/language_alias.php');
            if (array_key_exists($this->language, $language_alias)) {
                $i18n_date_js_file = $this->default_javascript_path . '/jquery_plugins/ui/i18n/datepicker/jquery.ui.datepicker-' . $language_alias[$this->language] . '.js';
                if (file_exists($i18n_date_js_file)) {
                    $this->set_js_lib($i18n_date_js_file);
                }
            }
        }

        $this->set_js_config($this->default_javascript_path . '/jquery_plugins/config/jquery.yearpicker.config.js');

        if (!empty($value) && $value != '0000-00-00' && $value != '1970-01-01') {
            $day = '01';
            $month = '01';
//            list($year, $month, $day) = explode('-', substr($value, 0, 10));
//            $date = date($this->php_date_format, mktime(0, 0, 0, $month, $day, $year));
            $date = date($this->php_date_format, mktime(0, 0, 0, $month, $day, $value));
        } else {
            $date = '';
        }

        $input = "<input id='field-{$field_info->name}' name='{$field_info->name}' type='text' value='2014' maxlength='10' class='yearpicker-input' style='width:50px;' />";

        $input .= "<style type='text/css'> .ui-datepicker-calendar, .ui-datepicker-month, .ui-datepicker-prev, .ui-datepicker-next {display: none;} </style>";
//        <a class='datepicker-input-clear' tabindex='-1'>" . $this->l('form_button_clear') . "</a> (" . $this->ui_date_format . ")";
        return $input;
    }

    /**
     * Get the html input for the specific field with the
     * current value
     *
     * @param object $field_info
     * @param string $value
     * @return object
     */
    protected function get_field_input($field_info, $value = null) {
        $real_type = $field_info->crud_type;

        $types_array = array(
            'integer',
            'text',
            'true_false',
            'string',
            'year',
            'date',
            'datetime',
            'enum',
            'set',
            'relation',
            'relation_readonly',
            'relation_n_n',
            'upload_file',
            'upload_file_readonly',
            'hidden',
            'password',
            'readonly',
            'dropdown',
            'multiselect'
        );

        if (in_array($real_type, $types_array)) {
            /* A quick way to go to an internal method of type $this->get_{type}_input .
             * For example if the real type is integer then we will use the method
             * $this->get_integer_input
             *  */
            $field_info->input = $this->{"get_" . $real_type . "_input"}($field_info, $value);
        } else {
            $field_info->input = $this->get_string_input($field_info, $value);
        }

        return $field_info;
    }

    protected function get_type($db_type) {
        $type = false;
        if (!empty($db_type->type)) {
            switch ($db_type->type) {
                case '1':
                case '3':
                case 'int':
                case 'tinyint':
                case 'mediumint':
                case 'longint':
                    if ($db_type->db_type == 'tinyint' && $db_type->db_max_length == 1)
                        $type = 'true_false';
                    else
                        $type = 'integer';
                    break;
                case '254':
                case 'string':
                case 'enum':
                    if ($db_type->db_type != 'enum')
                        $type = 'string';
                    else
                        $type = 'enum';
                    break;
                case 'set':
                    if ($db_type->db_type != 'set')
                        $type = 'string';
                    else
                        $type = 'set';
                    break;
                case '252':
                case 'blob':
                case 'text':
                case 'mediumtext':
                case 'longtext':
                    $type = 'text';
                    break;
                case '10':
                case 'year':
                case 'date':
                    $type = 'date';
                    break;
                case '12':
                case 'datetime':
                case 'timestamp':
                    $type = 'datetime';
                    break;
            }
        }
        return $type;
    }

    protected function change_list_value($field_info, $value = null) {
        $real_type = $field_info->crud_type;

        switch ($real_type) {
            case 'hidden':
            case 'invisible':
            case 'integer':

                break;
            case 'true_false':
                if (is_array($field_info->extras) && array_key_exists($value, $field_info->extras)) {
                    $value = $field_info->extras[$value];
                } else if (isset($this->default_true_false_text[$value])) {
                    $value = $this->default_true_false_text[$value];
                }
                break;
            case 'string':
                $value = $this->character_limiter($value, $this->character_limiter, "...");
                break;
            case 'text':
                $value = $this->character_limiter(strip_tags($value), $this->character_limiter, "...");
                break;
            case 'year':
                if (!empty($value) && $value != '0000-00-00') {
//                    $ci = &get_instance();
//                    $format = $ci->config->item('grocery_crud_default_date_format');
//                    
//                    $day = '01';
//                    $month = '01';
//                    $value = date($format, mktime(0, 0, 0, (int) $month, (int) $day, (int) $value));
            
            
//                    list($year, $month, $day) = explode("-", $value);
//                    $value = date($format, mktime(0, 0, 0, (int) $month, (int) $day, (int) $year));
                } else {
                    $value = '';
                }
                break;
            case 'date':
                if (!empty($value) && $value != '0000-00-00' && $value != '1970-01-01') {
                    list($year, $month, $day) = explode("-", $value);

                    $value = date($this->php_date_format, mktime(0, 0, 0, (int) $month, (int) $day, (int) $year));
                } else {
                    $value = '';
                }
                break;
            case 'datetime':
                if (!empty($value) && $value != '0000-00-00 00:00:00' && $value != '1970-01-01 00:00:00') {
                    list($year, $month, $day) = explode("-", $value);
                    list($hours, $minutes) = explode(":", substr($value, 11));

                    $value = date($this->php_date_format . " - H:i", mktime((int) $hours, (int) $minutes, 0, (int) $month, (int) $day, (int) $year));
                } else {
                    $value = '';
                }
                break;
            case 'enum':
                $value = $this->character_limiter($value, $this->character_limiter, "...");
                break;

            case 'multiselect':
                $value_as_array = array();
                foreach (explode(",", $value) as $row_value) {
                    $value_as_array[] = array_key_exists($row_value, $field_info->extras) ? $field_info->extras[$row_value] : $row_value;
                }
                $value = implode(",", $value_as_array);
                break;

            case 'relation_n_n':
                $value = $this->character_limiter(str_replace(',', ', ', $value), $this->character_limiter, "...");
                break;

            case 'password':
                $value = '******';
                break;

            case 'dropdown':
                $value = array_key_exists($value, $field_info->extras) ? $field_info->extras[$value] : $value;
                break;

            case 'upload_file':
                if (empty($value)) {
                    $value = "";
                } else {
                    $is_image = !empty($value) &&
                            ( substr($value, -4) == '.jpg' || substr($value, -4) == '.png' || substr($value, -5) == '.jpeg' || substr($value, -4) == '.gif' || substr($value, -5) == '.tiff') ? true : false;

                    $file_url = base_url() . $field_info->extras->upload_path . "/$value";

                    $file_url_anchor = '<a href="' . $file_url . '"';
                    if ($is_image) {
                        $file_url_anchor .= ' class="image-thumbnail"><img src="' . $file_url . '" height="50px">';
                    } else {
                        $file_url_anchor .= ' target="_blank">' . $this->character_limiter($value, $this->character_limiter, '...', true);
                    }
                    $file_url_anchor .= '</a>';

                    $value = $file_url_anchor;
                }
                break;

            default:
                $value = $this->character_limiter($value, $this->character_limiter, "...");
                break;
        }

        return $value;
    }

    /**
     *
     * The fields that user will see on add/edit
     *
     * @access	public
     * @param	string
     * @param	array
     * @return	void
     */
    public function fields() {
        $args = func_get_args();

        if (isset($args[0]) && is_array($args[0])) {
            $args = $args[0];
        }

        $this->add_fields = ($this->add_fields == null ? $args : array_merge($this->add_fields, $args));
        $this->edit_fields = ($this->edit_fields == null ? $args : array_merge($this->edit_fields, $args));

        return $this;
    }

    /**
     *
     * The fields that user can see . It is only for the add form
     */
    public function add_fields() {
        $args = func_get_args();

        if (isset($args[0]) && is_array($args[0])) {
            $args = $args[0];
        }

        $this->add_fields = ($this->add_fields == null ? $args : array_merge($this->add_fields, $args));

        return $this;
    }

    /**
     *
     *  The fields that user can see . It is only for the edit form
     */
    public function edit_fields() {
        $args = func_get_args();

        if (isset($args[0]) && is_array($args[0])) {
            $args = $args[0];
        }

        $this->edit_fields = ($this->edit_fields == null ? $args : array_merge($this->edit_fields, $args));


        return $this;
    }

     public function load_js_stock($filename)
    {
//		$this->set_css($this->default_css_path.'/jquery_plugins/chosen/chosen.css');
            $this->set_js_lib($this->default_assets_path.'/js/stock/'.$filename.'.js');
    }
}
