<?php

namespace App\Http\Controllers;

use App\Models\active_orders_person_data;
use App\Models\emailinbox;
use App\Models\emails_history;
use App\Models\new_leads_person_data;
use App\Models\phone_history;
use PhpImap\Mailbox;
use Illuminate\Http\Request;

class mailInbox
{
    public $user; //'test@zap489255-1.plesk07.zap-webspace.com'
    public $password; //Tarokyun12&&
    public $server;
    public $port;

    public function __construct($user, $password, $server, $port)
    {
        $this->user = $user;
        $this->password = $password;
        $this->server = $server;
        $this->port = $port;
    }

    public function connect($extrapath = null)
    {
        $emailInbox = new Mailbox(
            '{'.$this->server.':'.$this->port."/imap/ssl/novalidate-cert}$extrapath", // IMAP server

            $this->user,
            $this->password,
            public_path() . "/emailAttach"
        );

        return $emailInbox;
    }

    public function getEmails($model = null)
    {


        $inbox = $this->connect();
        $mails = $inbox->searchMailbox('NEW');

        $emailCollection = [];
        foreach ($mails as $mail) {
            $email = $inbox->getMail(
                $mail, 
                false 
            );
            if ($model != null) {
                array_push($emailCollection, $email);
            } else {
                array_push($emailCollection, $email);
            }
        }

        return $emailCollection;
    }

    public function findEmail($id)
    {
        $inbox = $this->connect();
        $email = $inbox->getMail($id, false);

        return $email;
    }

    public function assignToOrder($req)
    {
        $emails = emailinbox::all();
        $usedMails = array();
        foreach ($emails as $email) {
               
            if (str_contains($email->subject, '[#')) {
                $firstPart = explode('#', $email->subject);
                $secondPart = explode(']', $firstPart[1]);

                $id = $secondPart[0];
            } else {
                $counter = 0;
                $id = '';
                $found = false;
                $first = "";

                

                foreach (str_split($email->subject) as $char) {
                    
                    if ($found == false) {
                        
                        if (is_int(intval($char)) && intval($char) != 0) {
                            $counter++;
                            $id = $id . $char;
                        } else {
                            if($char != "0") {
                                $counter = 0;
                                $id = '';
                            }
                        }
                        if($char == "0") {
                                $counter++;
                                $id = $id . $char;
                            
                        }
                    }

                    if ($counter == 4) {
                        $found = true;
                        $split = explode($id, $email->subject);
                        $split = substr($split[0], -1); // returns "s"

                        if(!is_int($split)) {
                            $first = $split;
                            $id = $first . $id;
                            
                        }
                        $counter = 0;
                        
                    }
                }
                $lastChar = $char;
               
            }
            if (isset($id)) {
                if($found == true) {
                   
                    if($id != "") {
                        $user = active_orders_person_data::where('process_id', $id)->first();
                        if ($user == null) {
                            $user = new_leads_person_data::where('process_id', $id)->first();
                        }
                        
                        
                       }

                }

               
            }

            if (!isset($user)) {
            } else {
                if (isset($id)) {
                    
                    $his = emails_history::where('id', $email->id)->where('body', $email->text)->first();

                    if ($his == null) {
                        $history = new emails_history();
                        $history->process_id = $id;
                        $history->employee = $req->session()->get('username');
                        $history->status = 'Eingang | System';
                        $history->subject = $email->subject;
                        $history->body = $email->text;
                        $history->type = 'eingang';
                        $history->id = $email->id;
                        $history->save();
                        
                        $emailinbox = emailinbox::where("email_id", $email->email_id)->where("subject", $email->subject)->first();
                        $emailinbox->assigned = $id;
                        $emailinbox->update();

                        array_push($usedMails, $email->id);
                    }
                   
                }
            }

                       
                    
                
            
        }
        return $usedMails;
    }

    public function assignToOrderManuel($req, $id, $email_id)
    {
                $email = emailinbox::where("id", $email_id)->first();

                $his = emails_history::where('id', $email->email_id)->where('process_id', $id)->first();

                if ($his == null) {
                    $history = new emails_history();
                    $history->process_id = $id;
                    $history->employee = $req->session()->get('username');
                    $history->status = 'Eingang | Manuel';
                    $history->subject = $email->subject;
                    $history->body = $email->text;
                    $history->type = 'eingang';
                    $history->id = $email->id;
                    $history->save();

                    $phone = new phone_history();
                    $phone->process_id = $req->input("id");
                    $phone->lead_name = $email->subject;
                    $phone->status = "E-Mail";
                    $phone->message = $email->text;
                    $phone->employee = auth()->user()->id;
                    $phone->save();

                    $order = active_orders_person_data::where("process_id", $id)->first();
                    if($order == null) {
                        $order = new_leads_person_data::where("process_id", $id)->first();
                    }
                    $order->archiv = null;
                    $order->save();

                    $inbox   = emailinbox::where("email_id", $email->email_id)->get();

                    foreach($inbox as $ib) {
                        $ebox = emailinbox::where("id", $ib->id)->first();
                        $ebox->assigned = $id;
                        $ebox->update();
                    }
                }
            
                return $email;
    }



   
}
