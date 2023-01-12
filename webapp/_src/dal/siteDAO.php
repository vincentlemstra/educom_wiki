<?php
class SiteDAO 
{
//==============================================================================
// TO DO SELECT ITEMS FROM DATABASE
//==============================================================================
    public function getMenuItems(bool $loggedAuthor) : array
    {
        $menuitems = array( 'home' => 'home',
        'about' => 'over auteurs',
        'contact' => 'contact',
        'search' => 'zoeken',
        );
        if(!$loggedAuthor)
        {
            $menuitems +=   array('login' => 'login',
                            'register' => 'registratie');
        }else{
            $menuitems +=   array('logout' => 'uitloggen');
        };

        
        return $menuitems;

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
                'Jordi' => [
                    'id' => 0,
                    'name' => 'Jordi',
                ],
                'Koen' =>  [
                    'id' => 1,
                    'name' => 'Koen',
                ],
                'Yoeri' => [
                    'id' => 2,
                    'name' => 'Yoeri',
                ],
                'Vincent' => [
                    'id' => 4,
                    'name' => 'Vincent',
                ]
            ];

    } 
//==============================================================================
// TO DO SELECT ATRICLES FROM DATABASE
//==============================================================================
    public function getArticles() : array
    {
        return[
                'Article1' => [
                        'id' => 0,
                        'author' => 'Yoeri',
                        'beoordeling' => 5,
                        'title' => 'Title 1',       
                        'uitleg'=> 'Javascript wordt gebruikt om clientside elementen te manipuleren',
                        'tag' =>'Javascript',
                        'date_modified' => '20-12-2022',
                        'codeblock' => '',
                        'image'=>'article1.jpg'
                ],
                'Article2' => [
                        'id' => 1,
                        'author' => 'Koen',
                        'beoordeling' => 2,
                        'title' => 'Title 2',       
                        'uitleg'=> 'PHP is een server side language',
                        'tag' =>'PHP',
                        'date_modified' => '19-12-2022',
                        'codeblock' => '<?php echo "hello world"; ?>',
                        'image'=>'article2.jpg'
            ]
        ];

    }  
//==============================================================================
// TO DO SELECT ATRICLES FROM DATABASE BY ID
//==============================================================================
public function getArticleByID(int $id) : array
{
    switch ($id) 
    {
        case '0': return array(
                'id' => 0,
                'author' => 'Yoeri',
                'beoordeling' => 5,
                'title' => 'Title 1',       
                'uitleg'=> 'Javascript wordt gebruikt om clientside elementen te manipuleren',
                'tag' =>'Javascript',
                'date_modified' => '20-12-2022',
                'codeblock' => '',
                'image'=>'article1.jpg'
        );
        case '1': return array(
                'id' => 1,
                'author' => 'Koen',
                'beoordeling' => 2,
                'title' => 'Title 2',       
                'uitleg'=> 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'tag' =>'PHP',
                'date_modified' => '19-12-2022',
                'codeblock' => 'What is Lorem Ipsum?
                <BR>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                <BR>Why do we use it?
                It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using Content here, content here, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for lorem ipsum will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).
                <BR>Where does it come from?
                Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of de Finibus Bonorum et Malorum (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, Lorem ipsum dolor sit amet.., comes from a line in section 1.10.32.',
                'image'=>'article2.jpg'
        );
    }


} 
//==============================================================================
// TO DO SELECT TEXT FROM DATABASE
//==============================================================================
    public function getTextByPage(string $page) : string
    {
        switch ($page)
        {
            case 'about':
                return '<div class="bodycontent"><h1>Over de wiki</h1>'  
                . '<P>Sinds haar conceptie in 1982 is deze Wiki een begrip onder developers uit alle windstreken. '
                . 'Kunt u het niet vinden op deze site, dan bestaat het simpelweg niet. '
                . '</br></br>Stackoverwhat? Once you go Wiki, you never go panicki</br>- Linus Torvalds '
                . '</br></br>We will never need more than 640kb of RAM or more than this Wiki</br>- Bill Gates<br>'
                . ''
                . '</p>';
            case 'contact': 
                return '<h1>Contact</h1><p>Heb je vragen of opmerkingen over een reis, vul dan onderstaand formulier in en we nemen '
                . 'zsm contact met je op.</p>';
            case 'search': 
                return '<h1>Meer informatie</h1><p>Druk op [Bestellen!] om de roos te bestellen.</p>';
            case 'home':
                return '<div class="bodycontent"><h1>Welkom!</h1><p>Welkom op de website van de beste studenten van Educom, '
                . 'we gaan u vermaken met interessante artikelen over software/web ontwikkeling.</p></div>'
                //. '<img src="'.WEBIMG_FOLDER.'home.jpg" />'; 
                ;   
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
            case 'article':
            //case 'nieuw_item':
                return [
                    'title' => [
                        'type' => 'text',       
                        'label'=> 'Title',
                        'placeholder' => 'Vul hier het artikel naam in',
                    ],
                    'tag' => [
                        'type' => 'select multiple',
                        'label'=> 'selecteer Tag(s)',
                        'options' => [
                            'Javascript' => 'Javascript',
                            'PHP' => 'PHP',
                            'Ajax' => 'Ajax',
                            'CSS' => 'CSS',
                            ]
                        ],
                    'new tag' => [
                         'type' => 'text',
                         'label' =>'Nieuwe tag',
                         'placeholder' => 'Voeg nieuwe tag toe'
                    ],
                    'add' => [
                        'type' => 'submit',
                        'value' => 'toevoegen'
                    ],         
                    'image upload' => [
                        'type' => 'file',   
                        'label'=> 'image',
                        'placeholder' => 'huidige afbeelding overschrijven',
                    ],
                    'text' => [
                        'type' => 'textarea',
                        'label'=> 'artikel tekst',
                        'placeholder' => 'Vul hier de artikel met tekst',
                    ],
                    'codeblock' => [
                        'type' => 'textarea',
                        'label'=> 'Code-block',
                        'placeholder' => 'Vul hier het codeblok',
                    ],                    
                ];     
            default :
                // Show Error!!!
                return [];
        }        
    }
}