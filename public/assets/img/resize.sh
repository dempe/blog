#!/bin/bash

# Directory containing the images
IMAGE_DIR="."

# Desired maximum width and height
MAX_WIDTH=400
MAX_HEIGHT=300

# Iterate over all jpg images in the directory and resize them
for img in "$IMAGE_DIR"/*.{jpg,png}; do
  echo "Resizing $img";
  # magick "$img[0]" "$img";
  identify -format "%wx%h\n" "$img";
  # convert "$img" -resize "${MAX_WIDTH}x${MAX_HEIGHT}>" "$img";
done

echo "Image resizing complete."
