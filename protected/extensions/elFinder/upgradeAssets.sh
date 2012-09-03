#!/usr/bin/env sh

cd ./vendors/elFinder/vendors/elFinder/src/
make clean
make all

cp -r ../css ../../../assets/
cp -r ../js ../../../assets/
cp -r ../images ../../../assets/
cp -r ../connectors/php ../../../

cd ../../../