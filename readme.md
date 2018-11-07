
# Image Api
this api is a simple api that let you upload an image and get the image by a target code in original and custom size.

## Api Docker settings
default docker host for api is `http://localhost:8000` or `http://0.0.0.0:8000`.

to access database server go to address `http://localhost:8002` or `http://0.0.0.0:8002`.

## api url is in bellow

    {{ host }}/upload                               # uploads the image
    {{ host }}/url/{target_code}                    # returns the image url by target code
    {{ host }}/image/{target_code}                  # returns the image it self in original size
    {{ host }}/image/{target_code}/{width}x{height} # returns the image in wanted custom size
