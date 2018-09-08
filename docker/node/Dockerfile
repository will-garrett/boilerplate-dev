FROM node:8

RUN apt-get install -y git

WORKDIR /usr/app

RUN npm install

EXPOSE 3000

CMD ["npm", "start"]