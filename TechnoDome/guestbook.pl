
#! /user/bin/perl -w

use strict;



    my(%fields);

    my($sec, $min, $hour, $mday, $mon, $year) = (localtime(time))[0..5];

    my($dataFile) = "data/gestbook.dat";



    $mon  = zeroFill($mon, 2);

    $hour = zeroFill($hour, 2);

    $min  = zeroFill($min, 2);

    $sec  = zeroFill($sec, 2);

    $fields{'timestamp'} = "$mon/$mday/$year, $hour:$min:sec";



    getFormData(\%fields);

    saveFormData(\%fields, $dataFile);



    print("Content-type: text/html\n\n");

    print("<HTML>\n");

    print("<HEAD><TITLE>Guestbook</TITLE></HEAD>\n");

    print("<H1>Guestbook</H1>\n");

    print("<HR>\n");

    readFormData($dataFile);

    print("</BODY>\n");

    print("</HTML>\n");



sub getFormData {

    my($hashRef) = shift;

    my($buffer) = "";



    if ($ENV{'REQUEST_METHOD'} eq "GET") {

        $buffer = $ENV{'QUERY_STRING'};

    }

    else {

        read(STDIN, $buffer, $ENV{'CONTENT_LENGTH'});

    }



    foreach (split(/&/, $buffer)) {

        my($key, $value) = split(/=/, $_);

        $key   = decodeURL($key);

        $value = decodeURL($value);

        $value =~ s/(<P>\s*)+/<P>/g;   # compress multiple <P> tags.

        $value =~ s/</&lt;/g;           # turn off all HTML tags.

        $value =~ s/>/&gt;/g;

        $value =~ s/&lt;b&gt;/<b>/ig;    # turn on the bold tag.

        $value =~ s!&lt;/b&gt;!</b>!ig;

        $value =~ s/&lt;i&gt;/<b>/ig;    # turn on the italic tag.

        $value =~ s!&lt;/i&gt;!</b>!ig;

        $value =~ s!\cM!!g;            # Remove unneeded carriage re

        

    

        $value =~ s!\n\n!<P>!g;        # Convert 2 newlines into para

        $value =~ s!\n! !g;            # convert newline into space.



        %{$hashRef}->{$key} = $value;

    }



    $fields{'comments'} =~ s!\cM!!g;

    $fields{'comments'} =~ s!\n\n!<P>!g;

    $fields{'comments'} =~ s!\n!<BR>!g;

}



sub decodeURL {

    $_ = shift;

    tr/+/ /;

    s/%(..)/pack('c', hex($1))/eg;

    return($_);

}



sub zeroFill {

    my($temp) = shift;

    my($len)  = shift;

    my($diff) = $len - length($temp);



    return($temp) if $diff <= 0;

    return(('0' x $diff) . $temp);

}



sub saveFormData {

    my($hashRef) = shift;

    my($file)    = shift;



    open(FILE, ">>$file") or die("Unable to open Guestbook data file.");

    print FILE ("$hashRef->{'timestamp'}~");

    print FILE ("$hashRef->{'name'}~");

    print FILE ("$hashRef->{'email'}~");

    print FILE ("$hashRef->{'comments'}");

    print FILE ("\n");

    close(FILE);

}



sub readFormData {

    my($file)    = shift;



    open(FILE, "<$file") or die("Unable to open Guestbook data file.");

    while (<FILE>) {

        my($timestamp, $name, $email, $comments) = split(/~/, $_);



        print("$timestamp: <B>$name</B> <A HREF=mailto:$email>$email</A>\n");

        print("<OL><I>$comments</I></OL>\n");

        print("<HR>\n");



    }

    close(FILE);

}


