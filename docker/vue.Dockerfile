FROM node:lts-alpine

# copy both 'package.json' and 'package-lock.json' (if available)
# COPY package*.json ./

# install project dependencies
RUN npm install -g @vue/cli

RUN npm install -g @vue/cli-service-global

# copy project files and folders to the current working directory (i.e. 'app' folder)
# COPY . .

WORKDIR /app

# build app for production with minification
# RUN npm run build

# EXPOSE 8080
# CMD [ "http-server", "dist" ]
