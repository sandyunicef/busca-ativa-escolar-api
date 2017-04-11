<?php
/**
 * busca-ativa-escolar-api
 * SignupApproved.php
 *
 * Copyright (c) LQDI Digital
 * www.lqdi.net - 2017
 *
 * @author Aryel Tupinambá <aryel.tupinamba@lqdi.net>
 *
 * Created at: 22/02/2017, 15:57
 */

namespace BuscaAtivaEscolar\Mailables;

use BuscaAtivaEscolar\Tenant;
use BuscaAtivaEscolar\SignUp;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;

class SignupApproved extends Mailable {

	public $signup;
	public $tenant;

	public function __construct(SignUp $signup, Tenant $tenant) {
		$this->signup = $signup;
		$this->tenant = $tenant;
	}

	public function build() {

		$setupToken = $this->signup->getURLToken();
		$setupURL = env('APP_PANEL_URL') . "/admin_setup/" . $this->signup->id . '?token=' . $setupToken;

		$message = (new MailMessage())
			->subject("Sua adesão foi aprovada!")
			->greeting('Olá!')
			->line("A adesão de {$this->tenant->name} à Busca Ativa Escolar foi aprovada.")
			->line('Clique no botão abaixo para configurar a plataforma de seu município.')
			->success()
			->action('Configurar', $setupURL);

		$this->from(env('MAIL_USERNAME'), 'Busca Ativa Escolar');
		$this->subject("[Busca Ativa Escolar] Sua adesão foi aprovada!");

		return $this->view('vendor.notifications.email', $message->toArray());

	}

}