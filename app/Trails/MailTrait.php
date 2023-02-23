<?php
namespace App\Trails;


/**
 * summary
 */
trait MailTrait
{
    /**
     * summary
     */
   	public function initMailConfig(){

        $email = getSettings('smtp-config', '');
        config()->set('mail.from.name',!empty(@$email->name) ? @$email->name : config('mail.from.name'));
        config()->set('mail.from.address',filter_var(@$email->username,FILTER_VALIDATE_EMAIL) ? @$email->username : config('mail.from.address'));
        config()->set('mail.mailers.smtp.username',filter_var(@$email->username,FILTER_VALIDATE_EMAIL) ? @$email->username : config('mail.mailers.smtp.username'));
        config()->set('mail.mailers.smtp.password',strlen(@$email->password) ? @$email->password : config('mail.mailers.smtp.password'));
        config()->set('mail.mailers.smtp.host',strlen(@$email->host) ? @$email->host : config('mail.mailers.smtp.host'));
        config()->set('mail.mailers.smtp.port',strlen(@$email->port) ? @$email->port : config('mail.mailers.smtp.port'));
        config()->set('mail.mailers.smtp.encryption',strlen(@$email->encryption) ? @$email->encryption : config('mail.mailers.smtp.encryption'));
        config()->set('mail.mailers.smtp.transport',strlen(@$email->driver) ? @$email->driver : config('mail.mailers.smtp.transport'));
    }
}