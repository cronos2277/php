<?php
namespace Core\Mail;
use Zend\View\View;
use Zend\Mail\Message;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;
use Zend\Mail\Transport\Smtp as SmtTransport;
abstract class AbstractCoreMail
{
    protected $transport;
    protected $view;
    protected $body;
    protected $message;
    protected $subject;
    protected $to;
    protected $replyTo;
    protected $data;
    protected $page;
    protected $cc;

    public function __construct(SmtTransport $transport, View $view, $page)
    {
        $this->transport = $transport;
        $this->view = $view;
        $this->page = $page;
    }

    //Transport
    public function getTransport(){
        return $this->transport;
    }

    public function setTransport($transport){
        $this->transport = $transport;
        return $this;
    }

    //View
    public function getView(){
        return $this->view;
    }

    public function setView($view){
        $this->view = $view;
        return $this;
    }   

    //Body
    public function setBody($body){
        $this->body = $body;
        return $this;
    }

    public function getBody(){
        return $this->body;
    }

    //Message
    public function setMessage($message){
        $this->message = $message;
        return $this;
    }

    public function getMessage(){
        return $this->message;
    }

    //Subject
    public function setSubject($subject){
        $this->subject = $subject;
        return $this;
    }

    public function getSubject(){
        return $this->subject;
    }

    //To
    public function setTo($to){
        $this->to = $to;
        return $this;
    }

    public function getTo(){
        return $this->to;
    }

    //ReplyTo
    public function setReplyTo($replyTo){
        $this->replyTo = $replyTo;
        return $this;
    }

    public function getReplyTo(){
        return $this->replyTo;
    }

    //Data
    public function setData($data){
        $this->data = $data;
        return $this;
    }

    public function getData(){
        return $this->data;
    }

    //Page
    public function setPage($page){
        $this->page = $page;
        return $this;
    }

    public function getPage(){
        return $this->page;
    }

    //Cc
    public function setCc($cc){
        $this->cc = $cc;
        return $this;
    }

    public function getCc(){
        return $this->cc;
    }

    abstract public function renderView($page,array $data);

    public function prepare(){
        $html = new MimePart($this->renderView($this->page, $this->data));
        $html->type = 'text/html';
        $body = new MimeMessage();
        $body->setParts([$html]);
        $this->body = $body;
        $config = $this->transport->getOptions()->toArray();
        $this->message = new Message();
        $this->message->addFrom($config['connection_config']['from'])
        ->addTo($this->to)
        ->setSubject($this->subject)
        ->setBody($this->body);
        if($this->cc){
            $this->message->addCc($this->cc);
        }

        if($this->replyTo){
            $this->message->addCc($this->replyTo);
        }

        return $this;
    }

    public function send(){
        $this->transport->send($this->message);
    }
}