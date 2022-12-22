# The Cooking Assistant - API
An API to save your cooking recipes 🍪

### How does I make it works?
- First copy the .env.dist into .env and fill the required infos (regarding the DB)
- (Optional) Update your /etc/hosts to contains ```127.0.0.1 cooking-assistant.local```
- Then start it with ```docker compose up -d --build```
Et voilà! You should be able to access it heading to http://cooking-assistant.local:8085/

## TODO:
- Update everything (move to Symfony 6.2)
- Add validators
- Add Fixtures
- Add Unit Testing
- Add error strategy
- Add Auth system