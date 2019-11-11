FROM node:lts-alpine

# copy both 'package.json' and 'package-lock.json' (if available)
# COPY package*.json ./

# install project dependencies
RUN npm install -g @vue/cli

RUN npm install -g @vue/cli-service-global

RUN npm install http-server -g

ADD ./front /app

# copy project files and folders to the current working directory (i.e. 'app' folder)
# COPY . .

WORKDIR /app

RUN npm install

RUN npm run build

# build app for production with minification



EXPOSE 8080
CMD [ "http-server", "dist" ]
