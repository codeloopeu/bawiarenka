<?php declare(strict_types = 1);

include_once('helpers/HttpHelper.php');
include_once('helpers/JsonHelper.php');
include_once('helpers/MailHelper.php');

const SUBJECT = 'Bawiarenka - rezerwacja terminu';
const BAWIARENKA_EMAIL = 'bawiarenka@gmail.com';
const FORM_EMAIL = 'formularz@bawiarenka.com';
const DISPLAY_NAME = 'Bawiarenka';

function formatBody(string $email, string $body): string {
    return "
        <html lang=\"pl\">
            <body>
                <p>
                    E-mail: <a href='mailto:$email'>$email</a>
                </p>
                <p>
                    <span style='white-space: pre-line'>$body</span>
                </p>
            </body>
        </html>";
}

function formatConfirmationBody(): string {
    return "
        <html lang=\"pl\">
            <body>
                <p>Dziękujemy za wiadomość! Wkrótce odezwiemy się do Ciebie ze wszystkimi szczegółami.</p>
                <p>Bawiarenka<br>Witebska 2/u3, 03-507 Warszawa<br>tel. +48 791 198 682</p>
            </body>
        </html>";
}

function sendRequestMail(string $email, string $body) {
    $message = formatBody($email, $body);
    MailHelper::sendHtmlMail(BAWIARENKA_EMAIL, $email, FORM_EMAIL, SUBJECT, $message, $email);
}

function sendConfirmationMail(string $email) {
    $message = formatConfirmationBody();
    MailHelper::sendHtmlMail($email, DISPLAY_NAME, BAWIARENKA_EMAIL, SUBJECT, $message);
}

HttpHelper::checkIfPostOrDie();
$json = JsonHelper::getJsonFromBodyOrDie();

$email = htmlspecialchars(MailHelper::extractFirstEmailAddressOrDie(strtolower(trim((string) @$json['email']))));
$body = htmlspecialchars((string) @$json['body']);

sendRequestMail($email, $body);
sendConfirmationMail($email);

HttpHelper::setNoContentResponseStatusCode();
