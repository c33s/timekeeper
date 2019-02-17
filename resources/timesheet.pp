%token newline            \n
%token space              [\x20\x09\x0a\x0d]+
%token date               [0-9]{4}-[0-1][0-9]-[0-3][0-9] -> entry

%token entry:time         [0-9]{1,2}:[0-9]{1,2}
%token entry:break        \n\n -> default
%token entry:newline      \n
%token entry:space        \s
%token entry:text         [a-zA-Z0-9'"\h.-]+
%token entry:tag          @[a-zA-Z0-9-_]+
%token entry:bracket_     \[ -> category

%token category:name      [A-Za-z-_0-9]+
%token category:_bracket  \] -> entry

#document:
    date()*

#date:
    <date> <newline>? entry()*

#entry:
    <time> <space> category()? <space>? <text>? tag()* (<newline> | <break> )?

#category:
    <bracket_> <name> <_bracket>

#tag:
    <space>? <tag>

