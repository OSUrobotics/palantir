#!/bin/bash
cd ..
dpkg-scanpackages . /dev/null |gzip > release/Packages.gz
