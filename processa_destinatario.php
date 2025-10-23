<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once 'conexao.php';
require 'vendor/autoload.php'; 

// captura os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$localizacao = $_POST['localizacao'];
$id_ativo = $_POST['id_ativo'];

// insere no banco
$sql = "INSERT INTO destinatario (nome, email_usuario, localizacao, id_ativo) VALUES (?, ?, ?, ?)";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("sssi", $nome, $email, $localizacao, $id_ativo);

if ($stmt->execute()) {
    echo "Destinatário cadastrado com sucesso!";

    // Envia notificação por e-mail
    $assunto = "Novo ativo atribuído a você";
    $mensagem = "Olá, $nome! Você recebeu o ativo ID: $id_ativo.\n\n"
              . "Localização: $localizacao\n"
              . "Por favor, confirme o recebimento no sistema.";

    $headers = "From: sistema@empresa.com\r\n" .
               "Reply-To: sistema@empresa.com\r\n" .
               "X-Mailer: PHP/" . phpversion();

   if ($stmt->execute()) {
    echo "Destinatário cadastrado com sucesso!";
    echo "Volte para ao <a href='painel.php'>painel</a>";
    echo "Cadastre mais um <a href='cadastro_destinatarios.php'>destinatário</a>";

    $mail = new PHPMailer(true);

    try {
        //phpmailer utilizando gmail
        // deve usar as credenciais e o servidor do seu e-mail.
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Servidor SMTP (Gmail ou outro)
        $mail->SMTPAuth   = true;
        // SUBSTITUA pelo seu e-mail e pela Senha de Aplicativo
        //A senha de aplicativo é uma específica criada dentro das configurações de segurança do gmail, então sempre estará vinculada a apenas um gmail específico, caso queira mudar deve criar uma nova senha e vincular ao email
        $mail->Username   = 'mariaassis.dev@gmail.com'; 
        $mail->Password   = 'mkfk urqd llha lckh'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Usar SSL/TLS
        $mail->Port       = 465; // Porta padrão para SSL/TLS

        // Remetente e Destinatário
        $mail->setFrom('sistema@youtan.com', 'Sistema Youtan');
        $mail->addAddress($email, $nome); // Adiciona o destinatário

        // Conteúdo do E-mail
        $mail->isHTML(false); // E-mail em texto puro
        $mail->Subject = "Novo ativo atribuído a você - Youtan";
        $mail->Body    = "Olá, $nome! Você recebeu o ativo ID: $id_ativo.\n\n"
                       . "Localização: $localizacao\n"
                       . "Por favor, confirme o recebimento no sistema Youtan.";

        $mail->send();
        echo '<p>Notificação por e-mail enviada com sucesso!</p>';
    } catch (Exception $e) {
        // Esta mensagem de erro será exibida se houver falha na conexão SMTP
        echo "<p>Aviso: Notificação por e-mail não enviada. Erro: {$mail->ErrorInfo}</p>";
        // O restante do sistema (cadastro no banco) continua funcionando
    }
    

} else {
    echo "Erro ao cadastrar destinatário: " . $stmt->error;
}
} else {
    echo "Erro ao cadastrar destinatário: " . $stmt->error;
}
?>
