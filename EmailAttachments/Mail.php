<?php
class Mail extends MailCore
{
    public static function Send(
        $id_lang,
        $template,
        $subject,
        $template_vars,
        $to,
        $to_name = null,
        $from = null,
        $from_name = null,
        $file_attachment = null,
        $mode_smtp = null,
        $template_path = _PS_MAIL_DIR_,
        $die = false,
        $id_shop = null,
        $bcc = null,
        $reply_to = null
    ) {
        // Define different attachments for different email templates. 
        $attachments = array(
            'order_conf' => array(
                'ExampleAttachment.pdf',
                'ExampleAttachment2.pdf'
            ),
            'cancel' => array(
                'CancelationTerms.pdf'
            )
        );

        // Check if the template has defined attachments
        if (isset($attachments[$template])) {
            foreach ($attachments[$template] as $attachment) {
                $custom_attachment = array(
                    'content' => file_get_contents($attachment),
                    'name' => $attachment,
                    'mime' => 'application/pdf'
                );

                if ($file_attachment) {
                    if (!is_array($file_attachment)) {
                        $file_attachment = array($file_attachment);
                    }
                    $file_attachment[] = $custom_attachment;
                } else {
                    $file_attachment = array($custom_attachment);
                }
            }
        }

        return parent::Send(
            $id_lang,
            $template,
            $subject,
            $template_vars,
            $to,
            $to_name,
            $from,
            $from_name,
            $file_attachment,
            $mode_smtp,
            $template_path,
            $die,
            $id_shop,
            $bcc,
            $reply_to
        );
    }
}
