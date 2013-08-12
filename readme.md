*SIMPLE* Teleduino Web API
===========================

@version:  0.1
@author:   MDavid Low

@see:      http://www.teleduino.org/rtfm/api/328.php


# INTRODUCTION: 
This is a VERY basic API for accessing an Arduino running Teleduino.


APPLICABLE SERVO RANGES:
- angle: 160-100
- power: 130-110

- URL structure: api.php?&method[&actions]




##Controls:
- Angle (servo, vertical)
- Power (servo, horiz)
- Lock (pushes config to bot)
- Skip (fire)

##"Sensors":
- Wind
- Temp


### License:
MIT License

Copyright (c) 2013 MDavid Low (atypical)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.