<?php
class SiteDAO 
{
//==============================================================================
// TO DO SELECT ITEMS FROM DATABASE
//==============================================================================
    public function getMenuItems() : array
    {
        return[
                'home' => 'home',
                'about' => 'over auteurs',
                'contact' => 'contact',
                'zoeken' => 'zoeken',
                'login' => 'login',
                'registratie' => 'registratie',
            ];

        //when menu is in database we could use below...     
        //start function to get menu items from database
        //$sql = "SELECT * FROM MENU ORDER BY orderby";
        //return $this->_crud->selectMore("SELECT * FROM MENU ORDER BY orderby");
    }  
//==============================================================================
// TO DO SELECT AUTEURS FROM DATABASE
//==============================================================================
    public function getAuthors() : array
    {
        return[
                'Jordi' => 'Jordi',
                'Koen' => 'Koen',
                'Yoeri' => 'Yoeri',
                'Vincent' => 'Vincent'
            ];

    } 
//==============================================================================
// TO DO SELECT ATRICLES FROM DATABASE
//==============================================================================
    public function getArticles() : array
    {
        return[
                'Article1' => [
                        'title' => 'Title 1',       
                        'uitleg'=> 'Javascript wordt gebruikt om clientside elementen te manipuleren',
                        'tag' =>'Javascript',
                        'date_modified' => '20-12-2022',
                        'codeblock' => ''
                ],
                'Article' => [
                        'title' => 'Title 2',       
                        'uitleg'=> 'PHP is een server side language',
                        'tag' =>'PHP',
                        'date_modified' => '19-12-2022',
                        'codeblock' => '<?php echo "hello world"'
        ];

    }  
//==============================================================================
// TO DO SELECT TEXT FROM DATABASE
//==============================================================================
    public function getTextByPage(string $page) : string
    {
        switch ($page)
        {
            case 'about':
                return '<h1>Over de auteurs</h1><p>Ineens weet je het, je wordt Web Developer en start een opleiding bij Educom!</p>'
                //. '<img class="img-small" src="'.WEBIMG_FOLDER.'me.jpg" />'    
                . '<p>'
                . ' '
                . ' '
                . ' '
                . ' '
                . '</p>';
            case 'contact': 
                return '<h1>Contact</h1><p>Heb je vragen of opmerkingen over een reis, vul dan onderstaand formulier in en we nemen '
                . 'zsm contact met je op.</p>';
            case 'search': 
                return '<h1>Meer informatie</h1><p>Druk op [Bestellen!] om de roos te bestellen.</p>';
            case 'home':
                return '<h1>Welkom!</h1><p>Welkom op de website van de beste studenten van Educom, '
                . 'we gaan u vermaken met interessante artikelen over software/web ontwikkeling.</p>'
                //. '<img src="'.WEBIMG_FOLDER.'home.jpg" />';    
            case 'login': 
                return '<h1>Inloggen</h1><p>Heb je al een account en wil je een artikel schrijven? '
                . ' Vul dan je email-adres en wachtwoord in en druk op [Inloggen]</p>';
            case 'thanks': 
                return '<h1>Dank!</h1><p>We nemen zsm contact met je op.</p>';
            default:
                return '';
        }
    }    
//==============================================================================
// TO DO SELECT FIELDINFO FROM DATABASE
//==============================================================================
    public function getFormInfoByPage(string $page) : array
    {
        $submittxt = [
            'contact' => 'Versturen',  
            'login' => 'Inloggen',  
            'register' => 'Registreren',
            'search'  => 'Zoek artikelen'
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
             case 'search' :
                return [
                    'auteur' => [
                        'type' => 'select multiple',
                        'label'=> 'Selecteer auteur:',
                         'options' => [
                            'Jordi' => 'Jordi',
                            'Koen' => 'Koen',
                            'Yoeri' => 'Yoeri',
                            'Vincent'  => 'Vincent'
                        ]
                    ],  
                    'tag' => [
                        'type' => 'select multiple',   
                        'label'=> 'Selecteer Tag:',
                         'options' => [
                            'Javascript' => 'Javascript',
                            'PHP' => 'PHP',
                            'Ajax' => 'Ajax',
                            'MYSQL'  => 'MYSQL'
                        ]
                    ]
                ];    
            default :
                // Show Error!!!
                return [];
        }        
    }
}