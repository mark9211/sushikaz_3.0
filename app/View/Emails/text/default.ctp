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
<?php echo $name; ?> 様

--------------------------------------------------------------------
このメールは下記のいずれかに該当する方に、自動的に送信されています。

・当社スタッフ専用サイトWEB SMILEに登録された方
--------------------------------------------------------------------

WEB SMILEへの登録が完了いたしましたので
ご連絡させていただきました。皆様におかれましては、今後、以下の
情報を利用することが可能となります。

・勤務情報の確認
・給与明細の確認

--------------------------------------------------------------------
ご利用の際は以下のIDとパスワードを使ってログインしてください。

・Your ID: <?php echo $email; ?>

・Password: <?php echo $password; ?>

--------------------------------------------------------------------

【ログインは下記URLから可能です▽】
<?php echo $url; ?>


なお、このパスワードはプロフィールページで変更することが可能です。

