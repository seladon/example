FROM redis:6.0.8-alpine

### timezone ###
ARG TZ="Europe/Moscow"
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone