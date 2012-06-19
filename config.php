<?php
// Set defaults
if (!isset($config->url)) {
    $config->url = 'http://localhost/auth/service.soap';
}
if (!isset($config->method_name)) {
    $config->method_name = 'authenticate';
}
if (!isset($config->result_name)) {
    $config->result_name = 'result';
}
if (!isset($config->username_field)) {
    $config->username_field = 'username';
}
if (!isset($config->password_field)) {
    $config->password_field = 'password';
}
if (!isset($config->encoding)) {
    $config->encoding= 'utf-8';
}
?>

<p>
<label for="url"><?php print_string('auth_soap_url_key', 'auth_soap') ?></label>
<input name="url" id="url" type="text" size="30" value="<?php echo $config->url?>" />
<?php if (isset($err['url'])) { echo $OUTPUT->error_text($err['url']); } ?>
</p>

<p>
<label for="method_name"><?php print_string('auth_soap_method_name_key', 'auth_soap') ?></label>
<input name="method_name" id="method_name" type="text" size="30" value="<?php echo $config->method_name?>" />
<?php if (isset($err['method_name'])) { echo $OUTPUT->error_text($err['method_name']); } ?>
</p>

<p>
<label for="result_name"><?php print_string('auth_soap_result_name_key', 'auth_soap') ?></label>
<input name="result_name" id="result_name" type="text" size="30" value="<?php echo $config->result_name?>" />
<?php if (isset($err['result_name'])) { echo $OUTPUT->error_text($err['result_name']); } ?>
</p>

<p>
<label for="username_field"><?php print_string('auth_soap_username_field_key', 'auth_soap') ?></label>
<input name="username_field" id="username_field" type="text" size="30" value="<?php echo $config->username_field?>" />
<?php if (isset($err['username_field'])) { echo $OUTPUT->error_text($err['username_field']); } ?>
</p>

<p>
<label for="password_field"><?php print_string('auth_soap_password_field_key', 'auth_soap') ?></label>
<input name="password_field" id="password_field" type="text" size="30" value="<?php echo $config->password_field?>" />
<?php if (isset($err['password_field'])) { echo $OUTPUT->error_text($err['password_field']); } ?>
</p>

<p>
<label for="encoding"><?php print_string('auth_soap_encoding_key', 'auth_soap') ?></label>
<input name="encoding" id="encoding" type="text" size="30" value="<?php echo $config->encoding?>" />
<?php if (isset($err['encoding'])) { echo $OUTPUT->error_text($err['encoding']); } ?>
</p>

<p>
<label for="extra_parameters"><?php print_string('auth_soap_extra_parameters_key', 'auth_soap') ?></label>
<input name="extra_parameters" id="extra_parameters" type="text" size="30" value="<?php echo $config->extra_parameters?>" />
<?php if (isset($err['extra_parameters'])) { echo $OUTPUT->error_text($err['extra_parameters']); } ?>
</p>

