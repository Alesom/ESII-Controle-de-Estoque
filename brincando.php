
<!DOCTYPE html>
<html lang="pt-br">
 <head>
 <meta charset="UTF-8">
 <title>Web notification</title>
 </head>
 <body>
 <button onclick="notificarUsuario()">Testar</button>
 <script>
 function notificarUsuario(){
 // Caso window.Notification não exista, quer dizer que o browser não possui suporte a web notifications, então cancela a execução
 if(!window.Notification){
 return false;
 }
 
 // Função utilizada para enviar a notificação para o usuário
 var notificar = function(){
 var tituloMensagem = "Atenção usuário Fulano!";
 var icone = "http://www.seucurso.com.br/images/stories/logo.png";
 var mensagem = "Você recebeu uma nova mensagem em seu email";
 return new Notification(tituloMensagem,{
 icon : icone,
 body : mensagem
 });
 };
 
 // Verifica se existe a permissão para exibir a notificação; caso ainda não exista ("default"), então solicita permissão.
 // Existem três estados para a permissão:
 // "default" => o usuário ainda não deu nem negou permissão (neste caso deve ser feita a solicitação da permissão)
 // "denied" => permissão negada (como o usuário não deu permissão, o web notifications não irá funcionar)
 // "granted" => permissão concedida
 
 // A permissão já foi concedida, então pode enviar a notificação
 if(Notification.permission==="granted"){
 notificar();
 }else if(Notification.permission==="default"){
 // Solicita a permissão e caso o usuário conceda, envia a notificação
 Notification.requestPermission(function(permission){
 if(permission=="granted"){
 notificar();
 }
 });
 }
 };
 </script>
 </body>
</html>

