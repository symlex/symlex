#!/bin/bash

# This is the build script for JS deployment
# Please install steal first:
# npm install -g steal-tools

steal build --main app/app --config ../stealconfig.js 

