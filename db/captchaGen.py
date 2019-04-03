#!/usr/bin/env python3
# -*- coding: utf-8 -*-

import sqlite3 as sqlite
import uuid, random

con = sqlite.connect('db.sqlite')

for i in range(1,2000):
	n1=random.randint(1,200)
	n2=random.randint(1,200)
	
	question_code=uuid.uuid4().hex
	question_text="%s+%s" % (n1,n2)
	answer=str(n1+n2)
	print(question_text+'='+answer)
	with con:
		cur = con.cursor()
		cur.execute("INSERT INTO CAPTCHA VALUES(NULL,'%s','%s','%s')" % (question_code, question_text, answer) )
