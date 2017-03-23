<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.text
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>

本メールは、パスワード再発行手続きを
行われた方に自動的に送信させていただいております。

以下のURLをクリックして、パスワードの再設定を行ってください。
（尚このリンクは発行後24時間が経過すると無効になります。その場合はログインページからやり直してください。）

■新パスワード再設定用URL
<?php echo $url; ?>



