<table style="width: 100%;margin: 0 auto; background: #fff; color: #222; line-height: 24px; font-family: 'Segoe UI', Helvetica, Arial sans-serif ; font-size: 12px">
    <tr>
        <td>
            <table style="margin: 40px auto; width: 800px;">
                <tr>
                    <td style="width:20%;"><img src="http://<?php echo Kohana::$config->load('site.site_domain') ?>/uploads/system/logo/logo.png" style="display: block;margin: 0 auto 15px auto; width: 100%"></td>
                    <td style="width:60%;">
                        <h3 style="text-align: center"><?php echo Kohana::$config->load('site.site_title') ?></h3>
                        <h4 style="text-align: center"><?php echo Kohana::$config->load('site.site_slogan') ?></h4>
                    </td>
                    <td style="width:20%;">
                        <h4><?php echo Kohana::$config->load('site.phone1') ?></h4>
                        <h4><?php echo Kohana::$config->load('site.phone2') ?></h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <h3 style="color: #222; text-align: center">
                            <?php echo __('Здравствуйте! Вам пришло с сайта ').Kohana::$config->load('site.site_domain') ?>
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <?php if(isset($content)) echo $content; ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p style="color: #222; text-align: right">С уважением, робот сайта <a href="http://<?php echo Kohana::$config->load('site.site_domain') ?>" target="_blank"><?php echo Kohana::$config->load('site.site_domain') ?></a></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
