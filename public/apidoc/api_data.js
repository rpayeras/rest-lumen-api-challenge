define({ "api": [
  {
    "type": "post",
    "url": "/auth/login",
    "title": "Login",
    "name": "Login",
    "group": "Auth",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Token",
            "description": "<p>Auth token.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "username",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "password",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n  \"access_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9ncm91cGlwbS1hcGkudGVzdFwvYXV0aFwvbG9naW4iLCJpYXQiOjE2MTU5NzY2NjAsImV4cCI6MTYxNTk4MDI2MCwibmJmIjoxNjE1OTc2NjYwLCJqdGkiOiJzb0hDcXpsTW44NjhXelZXIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.G5P8DzMXQeJlXj1Fgt_-kgv_m4_zAO3eTnD2u5xza5E\",\n  \"token_type\": \"bearer\",\n  \"expires_in\": 3600\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/AuthController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/auth/refresh",
    "title": "Returns a refreshed token",
    "name": "Refresh_token",
    "group": "Auth",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Token",
            "description": "<p>Auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n  {\n  \"access_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9ncm91cGlwbS1hcGkudGVzdFwvYXV0aFwvbG9naW4iLCJpYXQiOjE2MTU5NzY2NjAsImV4cCI6MTYxNTk4MDI2MCwibmJmIjoxNjE1OTc2NjYwLCJqdGkiOiJzb0hDcXpsTW44NjhXelZXIiwic3ViIjoxLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.G5P8DzMXQeJlXj1Fgt_-kgv_m4_zAO3eTnD2u5xza5E\",\n  \"token_type\": \"bearer\",\n  \"expires_in\": 3600\n  }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/AuthController.php",
    "groupTitle": "Auth"
  },
  {
    "type": "post",
    "url": "/challenge/attendants",
    "title": "Store an attendant",
    "name": "Attendants",
    "group": "Challenge",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Token",
            "description": "<p>Auth token.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "firstname",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lastname",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "position",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "company",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "media",
            "description": "<p>Media sector (Outlet)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "media_category",
            "description": "<p>Nautic / Lifestyle / General</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "media_department",
            "description": "<p>Editorial / Advertisement</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "type_id",
            "description": "<p>Get it from /challenge/attendants/types (Selection Guest/Media/Sponsors/Collab)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n \"data\": {\"id\": 33},\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/ChallengeController.php",
    "groupTitle": "Challenge"
  },
  {
    "type": "post",
    "url": "/challenge/attendants/:id",
    "title": "Store an attendant",
    "name": "Attendants",
    "group": "Challenge",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Token",
            "description": "<p>Auth token.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "firstname",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "lastname",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "email",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "phone",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "position",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "company",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "media",
            "description": "<p>Media sector (Outlet)</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "media_category",
            "description": "<p>Nautic / Lifestyle / General</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": true,
            "field": "media_department",
            "description": "<p>Editorial / Advertisement</p>"
          },
          {
            "group": "Parameter",
            "type": "Integer",
            "optional": false,
            "field": "type_id",
            "description": "<p>Get it from /challenge/attendants/types (Selection Guest/Media/Sponsors/Collab)</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/ChallengeController.php",
    "groupTitle": "Challenge"
  },
  {
    "type": "get",
    "url": "/challenge/attendants/types",
    "title": "Get Attendant Types",
    "name": "Attendants",
    "group": "Challenge",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Token",
            "description": "<p>Auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": " HTTP/1.1 200 OK\n[\n    {\n       \"id\": 1,\n       \"name\": \"Selection Guest\"\n    },\n    {\n       \"id\": 2,\n       \"name\": \"Media\"\n    },\n    {\n       \"id\": 3,\n       \"name\": \"Sponsors\"\n    },\n    {\n       \"id\": 4,\n       \"name\": \"Collaborators\"\n    }\n]",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/ChallengeController.php",
    "groupTitle": "Challenge"
  },
  {
    "type": "post",
    "url": "/challenge/teams",
    "title": "Insert a team with members and documents",
    "name": "Insert_team",
    "group": "Challenge",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Token",
            "description": "<p>Auth token.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the team</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "brand",
            "description": "<p>Brand of boat</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "model",
            "description": "<p>Model of boat</p>"
          },
          {
            "group": "Parameter",
            "type": "Decimal",
            "optional": false,
            "field": "loa",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Decimal",
            "optional": false,
            "field": "draft",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Decimal",
            "optional": false,
            "field": "beam",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "class",
            "description": "<p>Class of boat</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sail_number",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Datetime",
            "optional": false,
            "field": "date_arrival",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Datetime",
            "optional": false,
            "field": "date_departure",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Decimal",
            "optional": true,
            "field": "container_size",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "members",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "members[firstname]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "members[lastname]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "members[phone]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "members[email]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "members[nationality]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "members[card_id]",
            "description": "<p>Card id of member, we use this for update members</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "documents",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "documents[name]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "documents[type]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "documents[file]",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n {\n \"data\": {\"id\": 33},\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/ChallengeController.php",
    "groupTitle": "Challenge"
  },
  {
    "type": "get",
    "url": "/challenge/members/categories",
    "title": "Member categories list",
    "name": "Members_categories_list",
    "group": "Challenge",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Token",
            "description": "<p>Auth token.</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK\n[\n    {\n      \"id\": 1,\n      \"name\": \"Team Manager\"\n    },\n    {\n      \"id\": 2,\n      \"name\": \"Captain\"\n    },\n    {\n      \"id\": 3,\n      \"name\": \"Crew\"\n    },\n    {\n      \"id\": 4,\n      \"name\": \"Owner\"\n    },\n    {\n      \"id\": 5,\n      \"name\": \"Diver\"\n    }\n]",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/ChallengeController.php",
    "groupTitle": "Challenge"
  },
  {
    "type": "get",
    "url": "/challenge/teams",
    "title": "Teams list",
    "name": "Teams_list",
    "group": "Challenge",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Token",
            "description": "<p>Auth token.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "filter",
            "description": "<p>Filter results</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "offset",
            "description": "<p>Offset results</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "limit",
            "description": "<p>Limit results</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "    HTTP/1.1 200 OK\n  [\n    {\n      \"id\": 33,\n      \"name\": \"Enterprise\",\n      \"brand\": \"Yamaha\",\n      \"model\": \"MT-230X1\",\n      \"loa\": \"23.20\",\n      \"draft\": \"23.50\",\n      \"beam\": \"12.20\",\n      \"sail_number\": \"ABD-12343\",\n      \"date_arrival\": \"2021-03-11 22:00:00\",\n      \"date_departure\": \"2021-03-15 09:00:00\",\n      \"class\": \"YACHT\",\n      \"external_diver_required\": null,\n      \"car_plate_number\": \"1234QQQ\",\n      \"container_size\": \"23.50\",\n      \"boat_id\": null,\n      \"created_at\": \"2021-03-16T13:23:41.000000Z\",\n      \"updated_at\": \"2021-03-16T13:24:45.000000Z\"\n  }\n]",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/ChallengeController.php",
    "groupTitle": "Challenge"
  },
  {
    "type": "post",
    "url": "/challenge/teams/:id",
    "title": "Update a team with members and documents",
    "name": "Update_team",
    "group": "Challenge",
    "header": {
      "fields": {
        "Header": [
          {
            "group": "Header",
            "type": "String",
            "optional": false,
            "field": "Token",
            "description": "<p>Auth token.</p>"
          }
        ]
      }
    },
    "parameter": {
      "fields": {
        "Parameter": [
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "name",
            "description": "<p>Name of the team</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "brand",
            "description": "<p>Brand of boat</p>"
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "model",
            "description": "<p>Model of boat</p>"
          },
          {
            "group": "Parameter",
            "type": "Decimal",
            "optional": false,
            "field": "loa",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Decimal",
            "optional": false,
            "field": "draft",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Decimal",
            "optional": false,
            "field": "beam",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "class",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "sail_number",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Datetime",
            "optional": false,
            "field": "date_arrival",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Datetime",
            "optional": false,
            "field": "date_departure",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Decimal",
            "optional": false,
            "field": "container_size",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "members",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "members[firstname]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "members[lastname]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "members[phone]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "members[email]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "members[nationality]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "members[card_id]",
            "description": "<p>Card id of member, we use this for update members</p>"
          },
          {
            "group": "Parameter",
            "type": "Object",
            "optional": false,
            "field": "documents",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "documents[name]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "String",
            "optional": false,
            "field": "documents[type]",
            "description": ""
          },
          {
            "group": "Parameter",
            "type": "File",
            "optional": false,
            "field": "documents[file]",
            "description": ""
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "HTTP/1.1 200 OK",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "app/Http/Controllers/ChallengeController.php",
    "groupTitle": "Challenge"
  }
] });
