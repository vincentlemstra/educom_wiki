<?php
class SiteDAO 
{
//==============================================================================
// TO DO SELECT FIELDINFO FROM DATABASE
//==============================================================================
    public function getFormInfoByPage(string $page) : array
    {
        $submittxt = [
            'contact' => 'Versturen',  
            'login' => 'Inloggen',  
            'register' => 'Registreren',
            'edit'  => 'Aanpassen of toevoegen'
        ];
        return [
            'page' => $page,
            'action' => '',
            'method' => 'POST',
            'submit' => Tools::getValueFromArray($page,$submittxt,'Bewaar')
        ];
    }    
//==============================================================================
// TO DO SELECT FIELDINFO FROM DATABASE
//==============================================================================
    public function getFieldInfoByPage(string $page) : array
    {
        switch ($page)
        {
            case 'contact' :
                return [
                    'name' => [
                        'type' => 'text', 		
                        'label'=> 'Je naam',
                        'placeholder' => 'Vul hier je naam in',
                        //'default' => //Tools::getSesVar(USERNAME)
                    ],		
                    'email' => [
                        'type' => 'email',
                        'label'=> 'Je email-adres',
                        'placeholder' => 'Vul hier je email-adres in',
                        'check_func' => 'validEmail',
                        //'default' => //Tools::getSesVar(USEREMAIL)
                    ],	
                    'phone' =>  [
                        'type' => 'tel',
                        'label'=> 'Je telefoonnummer',
                        'placeholder' => 'Vul hier je telefoonnummer in',
                    ],	
                    'message' => [
                        'type' => 'textarea',
                        'label'=> 'Je bericht',
                        'placeholder' => 'Vul hier je bericht in'
                    ],		
                    'contact' =>  [
                        'type' => 'select',
                        'label'=> 'Neem contact met op via',
                        'options' => [
                            'Email' => 'contact_email',
                            'Telefoon' => 'contact_phone',
                            'Postduif'  => 'contact_pidgeon'
                        ]
                    ]
                ];		
            case 'login' :
                return [
                    'email' => [
                        'type' => 'email',
                        'label'=> 'Je email-adres',
                        'placeholder' => 'Vul hier je email-adres in',
                        'check_func' => 'validEmail',
                        //'default' => Tools::getSesVar(USEREMAIL)
                    ],	
                    'password' => [
                        'type' => 'password', 		
                        'label'=> 'Je wachtwoord',
                        'placeholder' => 'Vul hier je wachtwoord in'
                    ]
                ];    
            case 'register' :
                return [
                    'name' => [
                        'type' => 'text', 		
                        'label'=> 'Je naam',
                        'placeholder' => 'Vul hier je naam in',
                    ],		
                    'email' => [
                        'type' => 'email',
                        'label'=> 'Je email-adres',
                        'placeholder' => 'Vul hier je email-adres in',
                        'check_func' => 'validEmail'
                    ],	
                    'password' => [
                        'type' => 'password', 		
                        'label'=> 'Je wachtwoord',
                        'placeholder' => 'Vul hier je wachtwoord in'
                    ],
                    'rep_password' => [
                        'type' => 'password', 		
                        'label'=> 'Herhaal je wachtwoord',
                        'placeholder' => 'Vul hier je wachtwoord in'
                    ]
                ];

            default :
                // Show Error!!!
                return [];
        }        
    }
}