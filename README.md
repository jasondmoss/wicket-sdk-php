wicket-sdk-php
==============

A PHP library for the Wicket Core API. https://wicket.io/technology

## example test payload

```json
cat > person.json
{
    "data": {
        "attributes": {
            "given_name": "given",
            "family_name": "family"
        },
        "relationships": {
            "emails": { 
                "data": [
                    { "type": "emails", "attributes": { "address": "name@ind.ninja", "primary": true } }
                ]
            }
        }
    }
}
```

```shell
$ http POST :3000/organizations/<org_id>/people < person.json
```
