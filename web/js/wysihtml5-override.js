var overrideOptions = {
    "font-styles": true,
    "emphasis": true,
    "lists": true,
    "html": true,
    "link": true,
    "image": true,
    events: {},
    parserRules: {
        tags: {
            "b":  {},
            "i":  {},
            "br": {},
            "ol": {},
            "ul": {},
            "li": {},
            "h1": {},
            "h2": {},
            "code": {},
            "strong": {},
            "em": {},
            "p": {
                "add_class": {
                    "align": "align_text"
                }
            },
            "u": 1,
            "img":  {
                "check_attributes": {
                    "width": "numbers",
                    "alt": "alt",
                    "src": "url",
                    "height": "numbers"
                }
            },
            "a":    {
                "set_attributes": {
                    "target": "_blank",
                    "rel":    "nofollow"
                },
                "check_attributes": {
                    "href":   "url" // important to avoid XSS
                }
            },
            "iframe": { // allow youtube iframe tag
                "remove": 0,
                "check_attributes": {
                    "width": "numbers",
                    "height": "numbers",
                    "src": "url",
                    "frameborder": "numbers"
                }
            }
        }
    }
};
