import matplotlib
matplotlib.use('Agg')
import numpy as np
import matplotlib.pyplot as plt
from pylab import savefig
f = open('temp.txt','rb')
for line in f:
    x = [int(i) for i in line.strip().split(' ')]
x = np.array(x)
plt.hist(x)
plt.savefig('histplot.png',format='png')
