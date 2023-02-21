import sys, getopt

def main(argv):
   wordCount = 3
   wordLength = 4
   numberCount = 3
   opts, args = getopt.getopt(argv,"hw:l:n:",["wordCount=","wordLength=","numberCount="])
   for opt, arg in opts:
      if opt == '-h':
         print ('pw.py -w <wordCount> -l <wordLength> -n <numberCount>')
         sys.exit()
      elif opt in ("-w", "--wordCount"):
         wordCount = arg
      elif opt in ("-l", "--wordLength"):
         wordLength = arg
      elif opt in ("-n", "--numberCount"):
         numberCount = arg
   print ('Word count is ', wordCount)
   print ('Word length is ', wordLength)
   print ('Number count is ', numberCount)
   
   # get words by word length

if __name__ == "__main__":
   main(sys.argv[1:])