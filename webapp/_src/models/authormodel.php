<?php
require_once "BaseModel.php";

class AuthorModel extends BaseModel
{
//===================================================================
// MAIN METHODS
//===================================================================

// NOTE: below method is not used currently, only in test
    public function getAllAuthors() : array
    {
        $sql = "SELECT id, firstname, preposition, lastname FROM author";
        return $this->_crud->selectMore($sql);
    }
//===================================================================

    public function getAllAuthorNames()
    {
        $sql = "SELECT CONCAT(firstname, ' ', IF(preposition IS NULL, '', CONCAT(preposition, ' ')), lastname) as Author, id FROM author;";
        return $this->_crud->readAll($sql);
    }

//===================================================================

    public function getAuthorById(int $id)
    {
        $sql = "SELECT * FROM author WHERE id=?";
        $var = [$id];
        return $this->_crud->readOne($sql, $var);
    }

//===================================================================

    public function getAuthorByEmail(string $email) : array|false
    {
        $sql = "SELECT id, email, password FROM author WHERE email=?";
        $var = [$email];
        return $this->_crud->readOne($sql, $var);            
    }

//===================================================================

    public function createAuthor(array $author)
    {
        $encr_pass = password_hash($author['password'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO author (firstname, preposition, lastname, email, date_birth, password) VALUES (?, ?, ?, ?, ?, ?)";
        $var = [$author['firstname'], $author['preposition'], $author['lastname'], $author['email'], $author['date_birth'], $encr_pass];
        return $this->_crud->create($sql, $var);
    }

//===================================================================
    // NOTE: how to update author details was not discussed, possible input array will be '$postresult'
    public function updateAuthor(array $author)
    {
        $sql = "UPDATE author SET firstname=?, preposition=?, lastname=?, email=?, date_birth=?, password=? WHERE id=?";
        $var = [$author['firstname'], $author['preposition'], $author['lastname'], $author['email'], $author['date_birth'], $author['password'], $author['id']];
        return $this->_crud->update($sql, $var);
    }

//===================================================================

    public function deleteAuthor(array $author)
    {
        // NOTE: how to delete authors was not discussed, possible input array will be '$postresult'
        $sql = "DELETE FROM author WHERE id=?";
        $var = [$author['id']];
        return $this->_crud->delete($sql, $var);
    }

//===================================================================
    public function handleLogin(array &$response) : FormElement|TextBlockViewElement|array|HtmlDoc
    {
        $var = $response['postresult']['email'];
        $authordetails = $this->getUserByEmail($response['postresult']['email']);
        if($authordetails == FALSE)
        {
                //Author is not legit, let's stay on Login Page! 
                require_once SRC.'views/form_element.php';
                //show form again with inputted values... 
                $this->doc = $this->createWikiDoc($response);
                $response[SYSERR] = "Het Email adres is onbekend!";
                $this->doc->addElement(new FormElement($response,$response['fieldinfo'], $response['postresult']));
                return $this->doc;
        }
        else
        {
            if ((trim($response['postresult']['password']) === trim($authordetails['password'])))
            {
                //Author is legit, let's go to Author or Home page ! Create and return Doc.. 
                $_SESSION[USERID] = $authordetails['id'];
                $_SESSION[USERNAME] = $authordetails['firstname'];
                $response[SYSMSG] = "welkom ".$authordetails['firstname'];
                $response['page']= 'home';
                $this->doc = $this->createWikiDoc($response);
                require_once SRC.'views/text_block_view_element.php';
                $this->doc->addElement(new TextBlockViewElement($this->sitedao->getTextByPage($response['page']),'div class="wrapper"'));
                return $this->doc;
            }
            else
            {
                //Author is not legit, let's stay on Login Page! 
                $response[SYSERR] = "password klopt niet!";
                require_once SRC.'views/form_element.php';
                //show form again with inputted values... 
                $this->doc = $this->createWikiDoc($response);
                $this->doc->addElement(new FormElement($response,$response['fieldinfo'], $response['postresult']));
                return $this->doc;
            }
        }
    }
    //==============================================================================
    public function getUserByEmail(string $email) : array|false
    {
        return $this->_crud->selectOne(
            "SELECT * FROM author WHERE email=:email",
            [
                'email' => [$email, false]
            ]    
        );
    }
    //==============================================================================    
    public function handleLogout(array &$response) : array
    {
        unset($_SESSION[USERID]);
        //unset($_SESSION[USERNAME]);
        //unset($_SESSION[USEREMAIL]);
        //unset($_SESSION[USERROLE]);
        $response['page']= 'home';
        $this->updateResponse($response);
        require_once SRC.'views/text_block_view_element.php';
        return $response;
    }
    //==============================================================================    
    public function handleContact(array &$response)  : HtmlDoc
    {
        $contactvorm = [
            'contact_email' => 'via mail naar <b>'.$response['postresult']['email'].'.</b>',
            'contact_phone' => 'per telefoon op nr <b>'.$response['postresult']['phone'].'.</b>',
            'contact_pidgeon'=>'middels een postduif die u wel weet te vinden.'
        ];
        $response[SYSMSG] = 'Beste '.$response['postresult']['name'].',<br/><br/>'
                          . 'dank voor uw contact-aanvraag.<br/><br/>'
                          . 'We nemen zsm contact met u op <br/> '  
                          . $contactvorm[$response['postresult']['contact']];
        $response['page']= 'home';
        $this->updateResponse($response);
        $this->doc = $this->createWikiDoc($response);
        require_once SRC.'views/text_block_view_element.php';
        $this->doc->addElement(new TextBlockViewElement($this->sitedao->getTextByPage($response['page']),'div class="wrapper"'));
        return $this->doc;
    }
}
?>


