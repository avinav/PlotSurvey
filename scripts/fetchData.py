#!//usr/bin/python2.7
'''import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt
from pylab import savefig'''
import numpy as np
import MySQLdb
import sys
qid = sys.argv[1]

db = MySQLdb.connect("localhost","root","oxford","CSE574")
cursor = db.cursor()
sql = "SELECT aid,pollval FROM answers \
        WHERE quesid = '"+qid+"'"
#print sql
aid = np.array([])
pollval = np.array([])
try:
    cursor.execute(sql)
    results = cursor.fetchall()
    for row in results:
        aid = np.append(aid,row[0])
        pollval = np.append(pollval, row[1])
except:
    print "Error: Unable to fetch data"
db.close()
#print aid,pollval
#plt.plot(aid,pollval)
#plt.savefig('histplot.png',format='png')
