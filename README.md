behat-sfk
=========

The Swiss File Knife File Tree Processor - Extension for Behat

This is a Behat extension I created for testing some PHP code against a FTP server. At the moment this extension is only tested with the ftpserv command.

# To install

1. Include **Realtime\SfkBehat\Extension** as extension in your behat configuration file, see: http://docs.behat.org/guides/7.config.html#extensions

2. Add as subcontext:
    + `$this->useContext('subcontext_alias', new \Realtime\SfkBehat\Context());`

# Steps

## Given a FTP server

    Given a local FTP server running on port "PORT" with these options "JSON_MAP"
    -or-
    Given a local FTP server running on port "PORT" with these options:
    """
    JSON_MAP
    """

**PORT** = Target port to run the FTP server on, e.g. the default port 21.
**JSON_MAP** = JSON key > value object with the following options:

    {
      "username" : "jeff",     // run ftp server with this username
      "password" : "p@sw0rd",  // run ftp server with this password
      "pasv_ip" : "127.0.0.1"  // return this ip adres in PASV response
                                  (default returns the first network interface IP found)
    }

## Assert FTPed file

    Then FTPed file "NAME" must be created, containing:
    """
    CONTENT
    """

**NAME** = Name of the uploaded file.
**CONTENT** = Content of the uploaded file.