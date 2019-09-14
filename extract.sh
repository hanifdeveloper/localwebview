#!bin/bash
loops=0;
for i in *.zip; 
do
    # echo ${i%%.zip};
    # let loops=$loops+1;
    folder=${i%%.zip};
    unzip -qq $i -d $folder;
    mv $i $folder;
    # if [ $loops -eq 2 ]; then exit; fi;
done