<?php
/**
* $Id: category.add.php,v 1.4 2005-09-25 09:47:02 thorstenr Exp $
*
* Adds a category
*
* @author       Thorsten Rinne <thorsten@phpmyfaq.de>
* @since        2003-12-20
* @copyright    (c) 2003-2005 phpMyFAQ Team
* 
* The contents of this file are subject to the Mozilla Public License
* Version 1.1 (the "License"); you may not use this file except in
* compliance with the License. You may obtain a copy of the License at
* http://www.mozilla.org/MPL/
* 
* Software distributed under the License is distributed on an "AS IS"
* basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
* License for the specific language governing rights and limitations
* under the License.
*/

if (!defined('IS_VALID_PHPMYFAQ_ADMIN')) {
    header('Location: http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

print "<h2>".$PMF_LANG["ad_categ_new"]."</h2>\n";
if ($permission["addcateg"]) {
    $cat = new Category;
?>
    <form action="<?php print $_SERVER["PHP_SELF"].$linkext; ?>" method="post">
    <fieldset>
    <legend><?php print $PMF_LANG["ad_categ_new"]; ?></legend>
    <input type="hidden" name="aktion" value="savecategory" />
    <input type="hidden" name="parent_id" value="<?php if (isset($_GET["cat"])) { print $_GET["cat"]; } else { print "0"; } ?>" />
<?php
    if (isset($_REQUEST["cat"])) {
?>
    <p><?php print $PMF_LANG["msgMainCategory"].": ".$cat->categoryName[$_GET["cat"]]["name"]; ?></p>
<?php
    }
?>
	<div class="row"><span class="label"><strong><?php print $PMF_LANG["ad_categ_titel"]; ?>:</strong></span>
    <input class="admin" type="text" name="name" size="30" style="width: 250px;" /></div>
    <div class="row"><span class="label"><strong><?php print $PMF_LANG["ad_categ_lang"]; ?>:</strong></span>
    <select name="lang" size="1">
    <?php print languageOptions($LANGCODE); ?>
    </select></div>
    <div class="row"><span class="label"><strong><?php print $PMF_LANG["ad_categ_desc"]; ?>:</strong></span>
    <input class="admin" type="text" name="description" size="30" style="width: 250px;" /></div>
    <div class="row"><span class="label"><strong><?php print $PMF_LANG["ad_categ_owner"]; ?>:</strong></span>
    <select name="cat_owner" size="1">    
<?php
        $result = $db->query("SELECT id, name, realname FROM ".SQLPREFIX."faquser ORDER BY id");
        while ($row = $db->fetch_object($result)) {
            print '<option value="'.$row->id.'"';
            if (strtolower($row->name) == 'admin') {
                print ' selected="selected"';
            }
            print '>';
            print $row->name;
            if (strlen($row->realname) > 0) {
                print ' ('.$row->realname.')';
            }
            print '</option>';
        }
?>
    </select></div>
    <div class="row"><span class="label"><strong>&nbsp;</strong></span>
    <input class="submit" type="submit" name="submit" value="<?php print $PMF_LANG["ad_categ_add"]; ?>" /></div>
    </fieldset>
	</form>
<?php
} else {
	print $PMF_LANG["err_NotAuth"];
}