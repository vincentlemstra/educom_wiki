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
            $sql = "SELECT firstname, preposition, lastname FROM author";
            return $this->crud->readAll($sql);
        }
    //===================================================================

        public function getAllAuthorNames()
        {
            $sql = "SELECT CONCAT(firstname, ' ', IF(preposition IS NULL, '', CONCAT(preposition, ' ')), lastname) as Author, id FROM author;";
            return $this->crud->readAll($sql);
        }
    
    //===================================================================
    
        public function getAuthorById(int $id)
        {
            $sql = "SELECT * FROM author WHERE id=?";
            $var = [$id];
            return $this->crud->readOne($sql, $var);
        }
    
    //===================================================================
    
        public function getAuthorByEmail(string $email) : array|false
        {
            $sql = "SELECT id, email, password FROM author WHERE email=?";
            $var = [$email];
            return $this->crud->readOne($sql, $var);            
        }
    
    //===================================================================
    
        public function createAuthor(array $author)
        {
            $encr_pass = password_hash($author['password'], PASSWORD_DEFAULT);
            $sql = "INSERT INTO author (firstname, preposition, lastname, email, date_birth, password) VALUES (?, ?, ?, ?, ?, ?)";
            $var = [$author['firstname'], $author['preposition'], $author['lastname'], $author['email'], $author['date_birth'], $encr_pass];
            return $this->crud->create($sql, $var);
        }
    
    //===================================================================
        // NOTE: how to update author details was not discussed, possible input array will be '$postresult'
        public function updateAuthor(array $author)
        {
            $sql = "UPDATE author SET firstname=?, preposition=?, lastname=?, email=?, date_birth=?, password=? WHERE id=?";
            $var = [$author['firstname'], $author['preposition'], $author['lastname'], $author['email'], $author['date_birth'], $author['password'], $author['id']];
            return $this->crud->update($sql, $var);
        }

    //===================================================================

        public function deleteAuthor(array $author)
        {
            // NOTE: how to delete authors was not discussed, possible input array will be '$postresult'
            $sql = "DELETE FROM author WHERE id=?";
            $var = [$author['id']];
            return $this->crud->delete($sql, $var);
        }

    //===================================================================

        public function handleLogin(array $postresult) : array
        {
            $sql = "SELECT id, password FROM author WHERE email=?";
            $var = [$postresult['email']];
            $authordetails = $this->crud->readOne($sql, $var);

            if($authordetails == FALSE)
            {
                $response['email_err'] = 'Onjuiste of onbekende email ingevoerd';
                return $response;
            }
            else
            {
                if (password_verify($postresult['password'], $authordetails['password']))
                {
                    $_SESSION['authorid'] = $authordetails['id'];
                    $response['page']= 'home';
                    return $response;
                }
                else
                {
                    $response['password_err'] = 'Ongeldig wachtwoord';
                    return $response;
                }
            }
        }
    }
?>



