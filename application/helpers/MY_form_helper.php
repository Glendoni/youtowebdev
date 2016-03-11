<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

function form_label_open($label_title, $label_name, $required=false) {
	return "<label for=\"$label_name\"><span>$label_title".($required ? "<abbr>*</abbr>" : "")."</span>";
}

function form_label_close() {
	return "</label>";
}

function form_label_readonly_open($label_title, $label_name, $required=false) {
	return "<label for=\"$label_name\"><span>$label_title".($required ? "<abbr>*</abbr>" : "")."</span><div class='readonly'>";
}

function form_label_readonly_close() {
	return "</div></label>";
}

function form_checkbox_group($name, $options, $value, $class) {
	$selected_form_values=array();
	if(count($value['values'])>0){
		$selected_form_values=$value['values'];
	}
	$str='';
	$count = count($options); 
	$str .='<div id="'.$name.'">';

	for($i=0; $i < $count; $i++){
		if ($name=='allergens'){
			$to_power= pow(2,$i);
		}else{
			$to_power=$i;
		}
	 
		$data = array(
		'name'		  =>$name.'[]',
		'value'       => $to_power,
		'checked'     =>FALSE,
		'class'       => $name,
		    );
		
		if(in_array("$to_power",$selected_form_values)) { $data['checked']=TRUE;}
	
		$str .= '<p class="'.$name.'">'.$options[ $to_power].'</p>'.form_checkbox($data);
	}
	$str .='</div>';
	return $str;
}
					
function generate_button_form($url, $data, $form_name='myform') {
	$str = form_open($url, array('id' => 'buttonForm', 'name' => $form_name));
	foreach ($data as $name => $value)
		$str .= form_hidden($name, $value);
	$str .= form_submit($form_name, 'Submit');
	$str .= form_close();
	return $str;
}
 
function get_facebook_app_config (){
	$CI =& get_instance();
	$CI->load->config('facebooklib_config');
	
	return array(
		'app_id' => $CI->config->item('facebook_app_id'),
		'app_secret' => $CI->config->item('facebook_app_secret'),
		'app_url' => $CI->config->item('facebook_app_url'),
		'app_name' => $CI->config->item('facebook_app_name'),
		'app_permissions' => $CI->config->item('facebook_permissions')
	);

function form_multiselect($name = '', $options = array(), $selected = array(), $extra = '')
    {
        if ( ! strpos($extra, 'multiple'))
        {
            $extra .= ' multiple="multiple"';
        }
        if ( ! strpos($name, '[]'))
        {
            $name .= '[]';
        }
        return form_dropdown($name, $options, $selected, $extra);
    }
}
