var overrideRules = {
    parserRules: {
        tags: {
            "iframe": {
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
