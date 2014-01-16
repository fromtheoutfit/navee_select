<?php

$data = '';

// Start the table
$this->table->set_template($cp_table_template);
$this->table->set_heading(array(lang('navee_select_include'),lang('navee_select_navigations')));

foreach($navs as $nav){
    $this->table->add_row(form_checkbox('hidden_' . $nav['id'], $nav['id'], $nav['is_hidden']), $nav['name']);
}

$data .= $this->table->generate();

echo $data;

/* End of file index.php */
/* Location: ./system/expressionengine/third_party/navee_select/views/mcp/display_settings.php */