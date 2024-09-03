# Dockerfile (in the client directory)
FROM node:18

# Set working directory
WORKDIR /app

# Install dependencies
COPY package*.json ./
RUN npm install

# Copy project files
COPY . .

# Build the app
RUN npm run build

# Install a simple HTTP server to serve the static files
RUN npm install -g serve

# Expose port 8080 and serve the app
EXPOSE 8080
CMD ["serve", "-s", "dist"]
