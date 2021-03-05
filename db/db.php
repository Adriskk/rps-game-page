<?php

    # => CONFIG FILE
    $FILENAME = 'database.ini';

    # => GET SECTIONS
    $config = parse_ini_file($FILENAME, true);

    # => GET OPTIONS
    $host = $config['DATABASE']['host'];
    $user = $config['DATABASE']['username'];
    $password = $config['DATABASE']['passwd'];
    $db = $config['DATABASE']['database_name'];
    $encoding = $config['DATABASE']['encoding'];

    # echo "{$host} {$user} {$password} {$db} \n";

    $connection = new PDO(
        "mysql:host={$host};dbname={$db};charset={$encoding}",
        $user,
        $password,
        [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]
    );


    function add_user_data(string $USERNAME, string $PASSWORD) {
        /**
         *
         * @return int - returns ID of the new user
         *
         * @param string $NAME - the name of the user
         * @param string $PASSWORD - user password to the accs
         *
         **/

        global $connection;

        # => DATABASE CONNECTION
        try {
            # => CHECK IF A GIVEN USER EXISTS IN DATABASE
            $sql = "SELECT id FROM user WHERE username = :username";
            $query = $connection->prepare($sql);

            # => BIND VALUES
            $query->bindValue(":username", $USERNAME, PDO::PARAM_STR);

            $query->execute() or die(" Query error occurred! ");
            $result = $query->fetch();
            var_dump($result);
            # => IF THE USER IS NEW
            if ($result != false) {
                return 'User with that username already exists!';

            } else {
                # => IF USER DOES NOT EXISTS IN DATABASE

                # => PREPARE QUERY
                $inq = "INSERT INTO user VALUES('', :USERNAME, :PASSWORD)";

                $query = $connection->prepare($inq);

                # => BIND VALUES
                $query->bindValue(':USERNAME', $USERNAME, PDO::PARAM_STR);          # INSERT THE NAME OF THE USER
                $query->bindValue(':PASSWORD', $PASSWORD, PDO::PARAM_STR);          # INSERT TIME

                # => EXECUTE QUERY
                $query->execute() or die(' Query error occurred! ');
                # echo "Added user";

                # => GET THE LAST ID FROM USER
                $last_inq = "SELECT id FROM user ORDER BY id DESC LIMIT 1";
                $last = $connection->prepare($last_inq);
                $last->execute() or die('Query error occurred! ');

                unset($connection);
                return $last->fetch();
            }

        } catch (PDOException $error) {
            exit ("[ Database error ] Database connection returned with error: {$error->getMessage()}");

        }
    }


    function add_rank($ID = NULL, array $POINTS = [], string $LEVEL) {
        /**
         *
         * @return boolean - returns a true if query OK or false if not
         *
         * @param int $ID - ID of the user
         * @param array $POINTS[] - array with user and ai points
         * @param string $LEVEL - level of ai
         *
         **/

        global $connection;

        if (($ID == NULL)) {
            throw new Exception("ID or points parameter cannot be NULL (default) - ID: {$ID}, points: {$points} ");
        }

        # => DATABASE CONNECTION
        try {

            # => ADD VALUES TO THE RANKING TABLE

            $ranking_inq = "INSERT INTO stats VALUES(:ID, :USER_POINTS, :AI_POINTS, :LEVEL)";

            $ranking_query = $connection->prepare($ranking_inq);

            $ranking_query->bindValue(':ID', $ID, PDO::PARAM_INT);  # INSERT LAST ID FROM TABLE USER
            $ranking_query->bindValue(':USER_POINTS', $POINTS['user'], PDO::PARAM_INT);  # INSERT USER POINTS
            $ranking_query->bindValue(':AI_POINTS', $POINTS['ai'], PDO::PARAM_INT);  # INSERT AI POINTS
            $ranking_query->bindValue(':LEVEL', $LEVEL, PDO::PARAM_INT);  # INSERT LEVEL

            var_dump($ID, $POINTS, $LEVEL);
            $ranking_query->execute() or die(' Query error occurred! ');

            unset($connection);
            return true;

        } catch (PDOException $error) {
            exit ("[ Database error ] Database connection returned with error: {$error}");

        }
    }


    # => FUNCTION USED TO UPDATE THE user TABLE FOR A GIVEN ID WITH A NEW BEST POINTS
    function update_best($ID = NULL, $time = NULL) {
        /**
         *
         * @return boolean - returns true if query OK else returns false
         *
         * @param int $ID - ID of the user
         * @param int $time - time of the game user played
         *
         **/

        global $connection;

        if (($ID == NULL) || ($time == NULL)) {
            throw new Exception("ID or points parameter cannot be NULL (default) - ID: {$ID}, points: {$time} ");
        }


        $sql = "UPDATE user SET best = :new WHERE user_id = :ID";

        $query = $connection->prepare($sql);

        $query->bindValue(":new", $time, PDO::PARAM_INT);
        $query->bindValue(":ID", $ID, PDO::PARAM_INT);

        $query->execute() or die("Query error occurred! ");

        return true;
    }


    # => FUNCTION USED TO GET THE USER DATA FROM GIVEN TABLE
    function get_user_data($ID=NULL, $TABLE = "user", $value = "all") {
        /**
         *
         * @return array - returns array of the user requested data
         *
         * @param int $ID - ID of the user
         * @param string $TABLE - the name of the table in database
         * @param string $value - the value parameter can accept 3 values
         *                     - 1 value a the call (all, user, best)
         *
         **/

        global $connection;

        # => DATABASE CONNECTION
        try {

            # => PREPARE QUERIES
            $col = ($TABLE == 'user' ? 'id' : 'user_id');

            if ($value == "all") {
                $inq = "SELECT * FROM {$TABLE}";
                $query = $connection->prepare($inq);

    //            $query->bindValue(':TAB', 'user', PDO::PARAM_STR);

            } else if(($value == "user") && ($ID != NULL)) {
                $inq = "SELECT user_points, ai_points FROM {$TABLE} WHERE {$col} = {$ID}";
                $query = $connection->prepare($inq);

    //            $query->bindValue(':tab', $TABLE, PDO::PARAM_STR);
    //            $query->bindValue(':col', $col, PDO::PARAM_STR);
    //            $query->bindValue(':id', $ID, PDO::PARAM_INT);

            } else if(($value == "best") && ($ID != NULL)) {
                $inq = "SELECT best FROM user WHERE {$col} = {$ID}";
                $query = $connection->prepare($inq);

    //            $query->bindValue(':col', $col, PDO::PARAM_STR);
    //            $query->bindValue(':id', $ID, PDO::PARAM_INT);

            } else {
                # => THROW EXCEPTION (THERE'S NO PARAMETER VALUE EQUAL SOMETHING OTHER THAN (all, user, best))
                throw new Exception("No parameter value - {$value} or ID of the user has to be passed");
            }

            $query->execute() or die(' Query error occurred! ');
            unset($connection);

            if ($value == 'all' || $value == 'user') {
                return $query->fetchall();

            } else {
                return $query->fetch();
            }


        } catch (PDOException $error) {
            exit ("[ Database error ] Database connection returned with error: {$error}");

        }
    }

    # => GET ALL USERS SORTED BY THEIR BEST POINTS
    function get_users_points() {
        /**
         *
         * @return array - returns the array of users
         *
         **/

        global $connection;

        try {
            $sql = "SELECT * FROM user ORDER BY best DESC";
            $query = $connection->prepare($sql);
            $query->execute() or die("Query error occurred! ");

            # => RETURN ALL FETCHED RECORDS -> SORTED (BY BEST TO THE LOWEST)
            return $query->fetchAll();

        } catch (PDOException $error) {
            exit ("[ Database error ] Database connection returned with error: {$error}");

        }
    }

    function get_points_of_user($ID=NULL) {
        /**
         *
         * @return array - returns the array of users
         *
         **/

        global $connection;

        if ($ID == NULL) {
            throw new Exception("ID or points parameter cannot be NULL (default) - ID: {$ID}");
        }

        try {
            $sql = "SELECT tries FROM ranking WHERE IDuser = :id ORDER BY tries DESC";
            $query = $connection->prepare($sql);
            $query->bindValue(':id', $ID, PDO::PARAM_INT);
            $query->execute() or die("Query error occurred! ");

            # => RETURN ALL FETCHED RECORDS -> SORTED (BY BEST TO THE LOWEST)
            return $query->fetchAll();

        } catch (PDOException $error) {
            exit ("[ Database error ] Database connection returned with error: {$error}");

        }
    }


    # => EXTRACT DATA FROM NESTED ARRAY
    function extract_all_data($array) {
        /**
         *
         * @return array - returns a tided and nested array of values
         * @param array $array - gets a nested array
         *
         * */

        $new = [
            [],  # user_id
            [],  # name
            []   # best
        ];

        foreach($array as $arr) {
            array_push($new[0], $arr["user_id"]);
            array_push($new[1], $arr["name"]);
            array_push($new[2], $arr["best"]);
        }

        return $new;
    }


    function check_if_user_exists($username) {

        global $connection;

        $sql = 'SELECT id, passwd from user WHERE username = :username';

        if (($username == '') && ($password == '')) return false;

        $username = str_replace(' ', '', $username);

        $username = trim($username);

        try {
            $query = $connection->prepare($sql);

            $query->bindValue(':username', $username, PDO::PARAM_STR);

            $query->execute() or die("Query error occured!");

            return $query->fetchAll();

        } catch(PDOException $error) {
            exit ("[ Database error ] Database connection returned with error: {$error}");

        }

        return false;
    }

    // GET LAST ID FROM DATABASE
    function get_last_id() {
        global $connection;

        try {
             # => GET THE LAST ID FROM USER
             $last_inq = "SELECT id FROM user ORDER BY id DESC LIMIT 1";
             $last = $connection->prepare($last_inq);
             $last->execute() or die('Query error occurred!');

             unset($connection);
             return $last->fetch();

        } catch(PDOException $error) {
            exit ("[ Database error ] Database connection returned with error: {$error}");
        }
    }


    function get_levels(int $ID = NULL) {
        global $connection;

        if ($ID == NULL) return false;

        try {
            # => GET THE LAST ID FROM USER
            $last_inq = "SELECT level FROM stats WHERE user_id = :ID";

            $last = $connection->prepare($last_inq);
            $last->bindValue(':ID', $ID, PDO::PARAM_INT);

            $last->execute() or die('Query error occurred!');

            unset($connection);
            return $last->fetchAll();

        } catch(PDOException $error) {
            exit ("[ Database error ] Database connection returned with error: {$error}");
        }
    }

    function get_username(int $ID = NULL) : string {
        global $connection;

        if ($ID == NULL) return false;

        try {
            # => GET THE LAST ID FROM USER
            $last_inq = "SELECT username FROM user WHERE id = :ID";

            $last = $connection->prepare($last_inq);
            $last->bindValue(':ID', $ID, PDO::PARAM_INT);

            $last->execute() or die('Query error occurred!');

            unset($connection);
            return $last->fetch()['username'];

        } catch(PDOException $error) {
            exit ("[ Database error ] Database connection returned with error: {$error}");
        }
    }
