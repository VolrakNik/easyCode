FROM node:23-alpine

ARG user

WORKDIR /var/www

USER $user
