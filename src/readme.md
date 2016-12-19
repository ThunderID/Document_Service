FORMAT: 1A

# Document

# Templates [/templates]
Template resource representation.

## Show all Templates [GET /templates]


+ Request (application/json)
    + Body

            {
                "search": {
                    "id": "string",
                    "title": "string",
                    "writer": "string"
                },
                "sort": {
                    "newest": "asc|desc",
                    "title": "desc|asc",
                    "writer": "desc|asc"
                },
                "take": "integer",
                "skip": "integer"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "data": {
                        "id": {
                            "value": "123456789",
                            "type": "string",
                            "max": "255"
                        },
                        "title": {
                            "value": "Template Akta Jual Beli Tanah",
                            "type": "string",
                            "max": "255"
                        },
                        "paragraph": {
                            "value": [
                                "Paragraph 1",
                                "Paragraph 2"
                            ],
                            "type": "array"
                        },
                        "writer": {
                            "value": {
                                "name": "Alana"
                            },
                            "type": "array"
                        }
                    },
                    "count": "integer"
                }
            }

## Store Template [POST /templates]


+ Request (application/json)
    + Body

            {
                "id": null,
                "title": "string",
                "paragraph": "array",
                "writer": "array"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "id": {
                        "value": "123456789",
                        "type": "string",
                        "max": "255"
                    },
                    "title": {
                        "value": "Template Akta Jual Beli Tanah",
                        "type": "string",
                        "max": "255"
                    },
                    "paragraph": {
                        "value": [
                            "Paragraph 1",
                            "Paragraph 2"
                        ],
                        "type": "array"
                    },
                    "writer": {
                        "value": {
                            "name": "Alana"
                        },
                        "type": "array"
                    }
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "status": {
                    "error": [
                        "writer name required."
                    ]
                }
            }

## Delete Template [DELETE /templates]


+ Request (application/json)
    + Body

            {
                "id": null
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "id": {
                        "value": "123456789",
                        "type": "string",
                        "max": "255"
                    },
                    "title": {
                        "value": "Template Akta Jual Beli Tanah",
                        "type": "string",
                        "max": "255"
                    },
                    "paragraph": {
                        "value": [
                            "Paragraph 1",
                            "Paragraph 2"
                        ],
                        "type": "array"
                    },
                    "writer": {
                        "value": {
                            "name": "Alana"
                        },
                        "type": "array"
                    }
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "status": {
                    "error": [
                        "writer name required."
                    ]
                }
            }

# Documents [/documents]
Document resource representation.

## Show all Documents [GET /documents]


+ Request (application/json)
    + Body

            {
                "search": {
                    "id": "string",
                    "title": "string",
                    "writer": "string"
                },
                "sort": {
                    "newest": "asc|desc",
                    "title": "desc|asc",
                    "writer": "desc|asc"
                },
                "take": "integer",
                "skip": "integer"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "data": {
                        "id": {
                            "value": "123456789",
                            "type": "string",
                            "max": "255"
                        },
                        "title": {
                            "value": "Template Akta Jual Beli Tanah",
                            "type": "string",
                            "max": "255"
                        },
                        "type": {
                            "value": "akta|ktp",
                            "type": "string",
                            "max": "255"
                        },
                        "paragraph": {
                            "value": [
                                "Paragraph 1",
                                "Paragraph 2"
                            ],
                            "type": "array"
                        },
                        "writer": {
                            "value": {
                                "name": "Alana"
                            },
                            "type": "array"
                        }
                    },
                    "count": "integer"
                }
            }

## Store Document [POST /documents]


+ Request (application/json)
    + Body

            {
                "id": null,
                "title": "string",
                "paragraph": "array",
                "writer": "array"
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "id": {
                        "value": "123456789",
                        "type": "string",
                        "max": "255"
                    },
                    "title": {
                        "value": "Template Akta Jual Beli Tanah",
                        "type": "string",
                        "max": "255"
                    },
                    "type": {
                        "value": "akta|ktp",
                        "type": "string",
                        "max": "255"
                    },
                    "paragraph": {
                        "value": [
                            "Paragraph 1",
                            "Paragraph 2"
                        ],
                        "type": "array"
                    },
                    "writer": {
                        "value": {
                            "name": "Alana"
                        },
                        "type": "array"
                    }
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "status": {
                    "error": [
                        "writer name required."
                    ]
                }
            }

## Delete Document [DELETE /documents]


+ Request (application/json)
    + Body

            {
                "id": null
            }

+ Response 200 (application/json)
    + Body

            {
                "status": "success",
                "data": {
                    "id": {
                        "value": "123456789",
                        "type": "string",
                        "max": "255"
                    },
                    "title": {
                        "value": "Template Akta Jual Beli Tanah",
                        "type": "string",
                        "max": "255"
                    },
                    "type": {
                        "value": "akta|ktp",
                        "type": "string",
                        "max": "255"
                    },
                    "paragraph": {
                        "value": [
                            "Paragraph 1",
                            "Paragraph 2"
                        ],
                        "type": "array"
                    },
                    "writer": {
                        "value": {
                            "name": "Alana"
                        },
                        "type": "array"
                    }
                }
            }

+ Response 200 (application/json)
    + Body

            {
                "status": {
                    "error": [
                        "writer name required."
                    ]
                }
            }