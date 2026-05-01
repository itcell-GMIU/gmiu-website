<form id="education_detail" method="POST">
    <div class="form-row">
        <p class="heading-p">SSC / 10th</p>
        <hr>
        <div class="form-group col-md-6">
            <label for="first_name">Board Name</label><span class="form_error_message">*</span>
            <select name="ssc_boardname" id="board_name_input_id" class="form-control select2me">
                <option selected="selected" value="">
                    Select Board
                    Name
                </option>
                <option value="Gujarat Board" <?php if ($ssc_boardname == "Gujarat Board") {
                    echo "selected";
                } ?>>
                    Gujarat Board
                </option>
                <option value="CBSE" <?php if ($ssc_boardname == "CBSE") {
                    echo "selected";
                } ?>>CBSE</option>
                <option value="ISCE" <?php if ($ssc_boardname == "ISCE") {
                    echo "selected";
                } ?>>ISCE
                </option>
                <option value="NIOS" <?php if ($ssc_boardname == "NIOS") {
                    echo "selected";
                } ?>>NIOS
                </option>
                <option value="IB" <?php if ($ssc_boardname == "IB") {
                    echo "selected";
                } ?>>IB
                </option>
                <option value="Andhra Pradesh Board of Intermediate Education" <?php if
                ($ssc_boardname == "Andhra Pradesh Board of Intermediate Education") {
                    echo "selected";
                } ?>>Andhra
                    Pradesh Board of Intermediate
                    Education
                </option>
                <option value="Andhra Pradesh Board of Secondary Education" <?php if
                ($ssc_boardname == "Andhra Pradesh Board of Secondary Education") {
                    echo "selected";
                } ?>>Andhra
                    Pradesh Board of Secondary Education
                </option>
                <option value="Assam Board of Secondary Education" <?php if
                ($ssc_boardname == "Assam Board of Secondary Education") {
                    echo "selected";
                } ?>>
                    Assam Board of Secondary Education
                </option>
                <option value="Bihar Intermediate Education Council" <?php if
                ($ssc_boardname == "Bihar Intermediate Education Council") {
                    echo "selected";
                } ?>>Bihar
                    Intermediate Education Council
                </option>
                <option value="Bihar School Examination Board" <?php if
                ($ssc_boardname == "Bihar School Examination Board") {
                    echo "selected";
                } ?>>Bihar
                    School Examination Board
                </option>
                <option value="Board of Higher Secondary Education,New Delhi" <?php if
                ($ssc_boardname == "Board of Higher Secondary Education,New Delhi") {
                    echo "selected";
                } ?>>Board of
                    Higher Secondary Education,New
                    Delhi
                </option>
                <option value="Board of School Education, Haryana" <?php if
                ($ssc_boardname == "Board of School Education, Haryana") {
                    echo "selected";
                } ?>>
                    Board of School Education, Haryana
                </option>
                <option value="Board of Secondary Education Kant Shahjahanpur Uttar Pradesh" <?php if
                ($ssc_boardname == "Board of Secondary Education Kant Shahjahanpur Uttar Pradesh") {
                    echo "selected"
                    ;
                } ?>>Board of Secondary Education Kant
                    Shahjahanpur Uttar
                    Pradesh</option>
                <option value="Board of Secondary Education Madhya Bharat Gwalior" <?php if
                ($ssc_boardname == "Board of Secondary Education Madhya Bharat Gwalior") {
                    echo "selected";
                } ?>>Board of Secondary Education
                    Madhya Bharat
                    Gwalior
                </option>
                <option value="Board of Secondary Education, Madhya Pradesh" <?php if
                ($ssc_boardname == "Board of Secondary Education, Madhya Pradesh") {
                    echo "selected";
                } ?>>Board of
                    Secondary Education, Madhya Pradesh
                </option>
                <option value="Board of Secondary Education, Rajasthan" <?php if
                ($ssc_boardname == "Board of Secondary Education, Rajasthan") {
                    echo "selected";
                } ?>>Board of
                    Secondary Education, Rajasthan </option>
                <option value="Board of Youth Education India" <?php if
                ($ssc_boardname == "Board of Youth Education India") {
                    echo "selected";
                } ?>>Board
                    of Youth Education India</option>
                <option value="Central Board Of Education Ajmer New Delhi" <?php if
                ($ssc_boardname == "Central Board Of Education Ajmer New Delhi") {
                    echo "selected";
                } ?>>Central
                    Board Of Education Ajmer New Delhi
                </option>
                <option value="Central Board Of Patna, Bihar" <?php if (
                    $ssc_boardname == "Central Board Of Patna, Bihar"
                ) {
                    echo "selected";
                } ?>>
                    Central Board Of Patna, Bihar</option>
                <option value="Chhattisgarh Board of Secondary Education" <?php if
                ($ssc_boardname == "Chhattisgarh Board of Secondary Education") {
                    echo "selected";
                } ?>>Chhattisgarh
                    Board of Secondary Education
                </option>
                <option value="Goa Board of Secondary & Higher Secondary Education" <?php if
                ($ssc_boardname == "Goa Board of Secondary & Higher Secondary Education") {
                    echo "selected";
                } ?>>Goa Board of Secondary &
                    Higher Secondary
                    Education
                </option>
                <option value="GSHSEB" <?php if ($ssc_boardname == "GSHSEB") {
                    echo "selected";
                } ?>>GSHSEB
                </option>
                <option value="Himachal Pradesh Board of School Education" <?php if
                ($ssc_boardname == "Himachal Pradesh Board of School Education") {
                    echo "selected";
                } ?>>Himachal
                    Pradesh Board of School Education
                </option>
                <option value="Institution of Secondary Distance Education" <?php if
                ($ssc_boardname == "Institution of Secondary Distance Education") {
                    echo "selected";
                } ?>>Institution of Secondary Distance Education
                </option>
                <option value="J&K State Board of School Education" <?php if
                ($ssc_boardname == "J&K State Board of School Education") {
                    echo "selected";
                } ?>>
                    J&K State Board of School Education
                </option>
                <option value="Jharkhand Academic Council" <?php if ($ssc_boardname == "Jharkhand Academic Council") {
                    echo "selected";
                } ?>>Jharkhand
                    Academic Council</option>
                <option value="Karnataka Board of the Pre-University Education" <?php if
                ($ssc_boardname == "Karnataka Board of the Pre-University Education") {
                    echo "selected";
                } ?>>Karnataka Board of the
                    Pre-University
                    Education
                </option>
                <option value="Karnataka Secondary Education Examination Board" <?php if
                ($ssc_boardname == "Karnataka Secondary Education Examination Board") {
                    echo "selected";
                } ?>>Karnataka Secondary Education
                    Examination
                    Board
                </option>
                <option value="Kerala Board of Public Examinations" <?php if
                ($ssc_boardname == "Kerala Board of Public Examinations") {
                    echo "selected";
                } ?>>
                    Kerala Board of Public Examinations
                </option>
                <option value="Madhya Pradesh State Open School Education Board" <?php if
                ($ssc_boardname == "Madhya Pradesh State Open School Education Board") {
                    echo "selected";
                } ?>>Madhya Pradesh State Open
                    School Education
                    Board
                </option>
                <option value="Maharashtra State Board of Secondary and Higher Secondary Education" <?php if
                ($ssc_boardname == "Maharashtra State Board of Secondary and Higher Secondary Education") {
                    echo "selected";
                } ?>>Maharashtra State Board of Secondary and
                    Higher
                    Secondary Education
                </option>
                <option value="Manipur Board of Secondary Education" <?php if
                ($ssc_boardname == "Manipur Board of Secondary Education") {
                    echo "selected";
                } ?>>Manipur Board of
                    Secondary Education
                </option>
                <option value="Manipur Council of Higher Secondary Education" <?php if
                ($ssc_boardname == "Manipur Council of Higher Secondary Education") {
                    echo "selected";
                } ?>>Manipur
                    Council of Higher Secondary
                    Education
                </option>
                <option value="Meghalaya Board of School Education" <?php if
                ($ssc_boardname == "Meghalaya Board of School Education") {
                    echo "selected";
                } ?>>
                    Meghalaya Board of School Education
                </option>
                <option value="Mizoram Board of School Education" <?php if
                ($ssc_boardname == "Mizoram Board of School Education") {
                    echo "selected";
                } ?>>
                    Mizoram Board of School Education
                </option>
                <option value="Nagaland Board of School Education" <?php if
                ($ssc_boardname == "Nagaland Board of School Education") {
                    echo "selected";
                } ?>>
                    Nagaland Board of School Education
                </option>
                <option value="Northwest Accreditation Commission & [NWAC]" <?php if
                ($ssc_boardname == "Northwest Accreditation Commission & [NWAC]") {
                    echo "selected";
                } ?>>Northwest
                    Accreditation Commission & [NWAC]
                </option>
                <option value="Orissa Board of Secondary Education" <?php if
                ($ssc_boardname == "Orissa Board of Secondary Education") {
                    echo "selected";
                } ?>>
                    Orissa Board of Secondary Education
                </option>
                <option value="Orissa Council of Higher Secondary Education" <?php if
                ($ssc_boardname == "Orissa Council of Higher Secondary Education") {
                    echo "selected";
                } ?>>Orissa
                    Council of Higher Secondary Education
                </option>
                <option value="Punjab School Education Board" <?php if (
                    $ssc_boardname == "Punjab School Education Board"
                ) {
                    echo "selected";
                } ?>>Punjab
                    School Education Board</option>
                <option value="Rajasthan Board of Secondary Education" <?php if
                ($ssc_boardname == "Rajasthan Board of Secondary Education") {
                    echo "selected";
                } ?>>Rajasthan Board
                    of Secondary Education
                </option>
                <option value="Sampurnanand Sanskrit Vishwavidyalaya Varanasi Uttar Pradesh" <?php if
                ($ssc_boardname == "Sampurnanand Sanskrit Vishwavidyalaya Varanasi Uttar Pradesh") {
                    echo "selected"
                    ;
                } ?>>
                    Sampurnanand Sanskrit Vishwavidyalaya Varanasi Uttar
                    Pradesh</option>
                <option value="Tamil Nadu Board of Higher Secondary Education" <?php if
                ($ssc_boardname == "Tamil Nadu Board of Higher Secondary Education") {
                    echo "selected";
                } ?>>Tamil
                    Nadu Board of Higher Secondary
                    Education
                </option>
                <option value="Tamil Nadu Board of Secondary Education" <?php if
                ($ssc_boardname == "Tamil Nadu Board of Secondary Education") {
                    echo "selected";
                } ?>>Tamil Nadu
                    Board of Secondary Education
                </option>
                <option value="Tamilnadu Council for Open and Distance Learning" <?php if
                ($ssc_boardname == "Tamilnadu Council for Open and Distance Learning") {
                    echo "selected";
                } ?>>Tamilnadu Council for Open and
                    Distance
                    Learning
                </option>
                <option value="Telangana State Board of Intermediate Education" <?php if
                ($ssc_boardname == "Telangana State Board of Intermediate Education") {
                    echo "selected";
                } ?>>Telangana State Board of
                    Intermediate
                    Education
                </option>
                <option value="The West Bengal Council of Rabindra Open Schooling" <?php if
                ($ssc_boardname == "The West Bengal Council of Rabindra Open Schooling") {
                    echo "selected";
                } ?>>The
                    West Bengal Council of Rabindra Open
                    Schooling
                </option>
                <option value="Tripura Board of Secondary Education" <?php if
                ($ssc_boardname == "Tripura Board of Secondary Education") {
                    echo "selected";
                } ?>>Tripura Board of
                    Secondary Education
                </option>
                <option value="Uttar Pradesh Board of High School and Intermediate Education" <?php if
                ($ssc_boardname == "Uttar Pradesh Board of High School and Intermediate Education") {
                    echo "selected"
                    ;
                } ?>>Uttar Pradesh Board of High School and
                    Intermediate
                    Education</option>
                <option value="Uttarakhand Board of School Education" <?php if
                ($ssc_boardname == "Uttarakhand Board of School Education") {
                    echo "selected";
                } ?>>
                    Uttarakhand Board of School Education
                </option>
                <option value="H P Board Of School Education" <?php if (
                    $ssc_boardname == "H P Board Of School Education"
                ) {
                    echo "selected";
                } ?>>
                    H P Board Of School Education
                </option>
                <option value="J & K State Board Of School Education" <?php if
                ($ssc_boardname == "J & K State Board Of School Education") {
                    echo "selected";
                } ?>>
                    J & K State Board Of School Education
                </option>
                <option value="West Bengal Board of Secondary Education" <?php if
                ($ssc_boardname == "West Bengal Board of Secondary Education") {
                    echo "selected";
                } ?>>West Bengal
                    Board of Secondary Education
                </option>
                <option value="West Bengal Council of Higher Secondary Education" <?php if
                ($ssc_boardname == "West Bengal Council of Higher Secondary Education") {
                    echo "selected";
                } ?>>West
                    Bengal Council of Higher Secondary
                    Education
                </option>
                <option value="KARNATAKA PRE-UNIVERSITY EDUCATION EXAMINATION" <?php if
                ($ssc_boardname == "KARNATAKA PRE-UNIVERSITY EDUCATION EXAMINATION") {
                    echo "selected";
                } ?>>
                    KARNATAKA PRE-UNIVERSITY EDUCATION EXAMINATION</option>
                <option value="West Bengal State Council of Vocational Education and Training" <?php if
                ($ssc_boardname == "West Bengal State Council of Vocational Education and Training") {
                    echo "selected";
                } ?>>West Bengal State Council of Vocational
                    Education and
                    Training</option>
            </select>

        </div>

        <div class="form-group col-md-6">
            <label for="middle_name">School Name</label>`
            <input name="ssc_schoolname" value="<?php echo $ssc_schoolname; ?>" type="text" maxlength="250"
                id="school_name_input_id" class="form-control" placeholder="Enter School Name" />

        </div>
    </div>
    <div class="form-row">
        <hr>
        <div class="form-group col-md-4">
            <label for="last_name">Aggregate Percentage</label><span class="form_error_message">*</span>
            <input value="<?php echo $ssc_percentage; ?>" name="ssc_percentage" type="text" maxlength="5"
                id="percentage_input_id" class="form-control" placeholder="Enter Aggregate Percentage" />
        </div>

        <div class="form-group col-md-4">
            <label for="last_name">Passing Month</label><span class="form_error_message">*</span>
            <select name="ssc_passingmonth" id="passmon_input_id" class="form-control select2me">
                <option value=""> MM
                </option>
                <option value="01" <?php if ($ssc_passingmonth == "01") {
                    echo "selected";
                } ?>>01</option>
                <option value="02" <?php if ($ssc_passingmonth == "02") {
                    echo "selected";
                } ?>>02</option>
                <option value="03" <?php if ($ssc_passingmonth == "03") {
                    echo "selected";
                } ?>>03</option>
                <option value="04" <?php if ($ssc_passingmonth == "04") {
                    echo "selected";
                } ?>>04</option>
                <option value="05" <?php if ($ssc_passingmonth == "05") {
                    echo "selected";
                } ?>>05</option>
                <option value="06" <?php if ($ssc_passingmonth == "06") {
                    echo "selected";
                } ?>>06</option>
                <option value="07" <?php if ($ssc_passingmonth == "07") {
                    echo "selected";
                } ?>>07</option>
                <option value="08" <?php if ($ssc_passingmonth == "08") {
                    echo "selected";
                } ?>>08</option>
                <option value="09" <?php if ($ssc_passingmonth == "09") {
                    echo "selected";
                } ?>>09</option>
                <option value="10" <?php if ($ssc_passingmonth == "10") {
                    echo "selected";
                } ?>>10
                </option>
                <option value="11" <?php if ($ssc_passingmonth == "11") {
                    echo "selected";
                } ?>>11
                </option>
                <option value="12" <?php if ($ssc_passingmonth == "12") {
                    echo "selected";
                } ?>>12
                </option>
            </select>
        </div>

        <div class="form-group col-md-4">
            <label for="gender">Passing Year</label><span class="form_error_message">*</span>
            <select name="ssc_passingyear" id="passyear_input_id" class="form-control select2me">
                <option value=""> YYYY
                </option>
                <option value="2023" <?php if ($ssc_passingyear == "2023") {
                    echo "selected";
                } ?>>2023
                </option>
                <option value="2022" <?php if ($ssc_passingyear == "2022") {
                    echo "selected";
                } ?>>2022
                </option>
                <option value="2021" <?php if ($ssc_passingyear == "2021") {
                    echo "selected";
                } ?>>2021
                </option>
                <option value="2020" <?php if ($ssc_passingyear == "2020") {
                    echo "selected";
                } ?>>2020
                </option>
                <option value="2019" <?php if ($ssc_passingyear == "2019") {
                    echo "selected";
                } ?>>2019
                </option>
                <option value="2018" <?php if ($ssc_passingyear == "2018") {
                    echo "selected";
                } ?>>2018
                </option>
                <option value="2017" <?php if ($ssc_passingyear == "2017") {
                    echo "selected";
                } ?>>2017
                </option>
                <option value="2016" <?php if ($ssc_passingyear == "2016") {
                    echo "selected";
                } ?>>2016
                </option>
                <option value="2015" <?php if ($ssc_passingyear == "2015") {
                    echo "selected";
                } ?>>2015
                </option>
                <option value="2014" <?php if ($ssc_passingyear == "2014") {
                    echo "selected";
                } ?>>2014
                </option>
                <option value="2013" <?php if ($ssc_passingyear == "2013") {
                    echo "selected";
                } ?>>2013
                </option>
                <option value="2012" <?php if ($ssc_passingyear == "2012") {
                    echo "selected";
                } ?>>2012
                </option>
                <option value="2011" <?php if ($ssc_passingyear == "2011") {
                    echo "selected";
                } ?>>2011
                </option>
                <option value="2010" <?php if ($ssc_passingyear == "2010") {
                    echo "selected";
                } ?>>2010
                </option>
                <option value="2009" <?php if ($ssc_passingyear == "2009") {
                    echo "selected";
                } ?>>2009
                </option>
                <option value="2008" <?php if ($ssc_passingyear == "2008") {
                    echo "selected";
                } ?>>2008
                </option>
                <option value="2007" <?php if ($ssc_passingyear == "2007") {
                    echo "selected";
                } ?>>2007
                </option>
                <option value="2006" <?php if ($ssc_passingyear == "2006") {
                    echo "selected";
                } ?>>2006
                </option>
                <option value="2005" <?php if ($ssc_passingyear == "2005") {
                    echo "selected";
                } ?>>2005
                </option>
                <option value="2004" <?php if ($ssc_passingyear == "2004") {
                    echo "selected";
                } ?>>2004
                </option>
                <option value="2003" <?php if ($ssc_passingyear == "2003") {
                    echo "selected";
                } ?>>2003
                </option>
                <option value="2002" <?php if ($ssc_passingyear == "2002") {
                    echo "selected";
                } ?>>2002
                </option>
                <option value="2001" <?php if ($ssc_passingyear == "2001") {
                    echo "selected";
                } ?>>2001
                </option>
                <option value="2000" <?php if ($ssc_passingyear == "2000") {
                    echo "selected";
                } ?>>2000
                </option>
                <option value="1999" <?php if ($ssc_passingyear == "1999") {
                    echo "selected";
                } ?>>1999
                </option>
                <option value="1998" <?php if ($ssc_passingyear == "1998") {
                    echo "selected";
                } ?>>1998
                </option>
                <option value="1997" <?php if ($ssc_passingyear == "1997") {
                    echo "selected";
                } ?>>1997
                </option>
                <option value="1996" <?php if ($ssc_passingyear == "1996") {
                    echo "selected";
                } ?>>1996
                </option>
                <option value="1995" <?php if ($ssc_passingyear == "1995") {
                    echo "selected";
                } ?>>1995
                </option>
                <option value="1994" <?php if ($ssc_passingyear == "1994") {
                    echo "selected";
                } ?>>1994
                </option>
                <option value="1993" <?php if ($ssc_passingyear == "1993") {
                    echo "selected";
                } ?>>1993
                </option>
                <option value="1992" <?php if ($ssc_passingyear == "1992") {
                    echo "selected";
                } ?>>1992
                </option>
                <option value="1991" <?php if ($ssc_passingyear == "1991") {
                    echo "selected";
                } ?>>1991
                </option>
                <option value="1990" <?php if ($ssc_passingyear == "1990") {
                    echo "selected";
                } ?>>1990
                </option>
                <option value="1989" <?php if ($ssc_passingyear == "1989") {
                    echo "selected";
                } ?>>1989
                </option>
                <option value="1988" <?php if ($ssc_passingyear == "1988") {
                    echo "selected";
                } ?>>1988
                </option>
                <option value="1987" <?php if ($ssc_passingyear == "1987") {
                    echo "selected";
                } ?>>1987
                </option>
                <option value="1986" <?php if ($ssc_passingyear == "1986") {
                    echo "selected";
                } ?>>1986
                </option>
                <option value="1985" <?php if ($ssc_passingyear == "1985") {
                    echo "selected";
                } ?>>1985
                </option>
                <option value="1984" <?php if ($ssc_passingyear == "1984") {
                    echo "selected";
                } ?>>1984
                </option>
                <option value="1983" <?php if ($ssc_passingyear == "1983") {
                    echo "selected";
                } ?>>1983
                </option>
                <option value="1982" <?php if ($ssc_passingyear == "1982") {
                    echo "selected";
                } ?>>1982
                </option>
                <option value="1981" <?php if ($ssc_passingyear == "1981") {
                    echo "selected";
                } ?>>1981
                </option>
                <option value="1980" <?php if ($ssc_passingyear == "1980") {
                    echo "selected";
                } ?>>1980
                </option>
                <option value="1979" <?php if ($ssc_passingyear == "1979") {
                    echo "selected";
                } ?>>1979
                </option>
                <option value="1978" <?php if ($ssc_passingyear == "1978") {
                    echo "selected";
                } ?>>1978
                </option>
                <option value="1977" <?php if ($ssc_passingyear == "1977") {
                    echo "selected";
                } ?>>1977
                </option>
                <option value="1976" <?php if ($ssc_passingyear == "1976") {
                    echo "selected";
                } ?>>1976
                </option>
                <option value="1975" <?php if ($ssc_passingyear == "1975") {
                    echo "selected";
                } ?>>1975
                </option>
                <option value="1974" <?php if ($ssc_passingyear == "1974") {
                    echo "selected";
                } ?>>1974
                </option>
                <option value="1973" <?php if ($ssc_passingyear == "1973") {
                    echo "selected";
                } ?>>1973
                </option>
                <option value="1972" <?php if ($ssc_passingyear == "1972") {
                    echo "selected";
                } ?>>1972
                </option>
                <option value="1971" <?php if ($ssc_passingyear == "1971") {
                    echo "selected";
                } ?>>1971
                </option>
                <option value="1970" <?php if ($ssc_passingyear == "1970") {
                    echo "selected";
                } ?>>1970
                </option>
                <option value="1969" <?php if ($ssc_passingyear == "1969") {
                    echo "selected";
                } ?>>1969
                </option>
                <option value="1968" <?php if ($ssc_passingyear == "1968") {
                    echo "selected";
                } ?>>1968
                </option>
                <option value="1967" <?php if ($ssc_passingyear == "1967") {
                    echo "selected";
                } ?>>1967
                </option>
                <option value="1966" <?php if ($ssc_passingyear == "1966") {
                    echo "selected";
                } ?>>1966
                </option>
                <option value="1965" <?php if ($ssc_passingyear == "1965") {
                    echo "selected";
                } ?>>1965
                </option>
                <option value="1964" <?php if ($ssc_passingyear == "1964") {
                    echo "selected";
                } ?>>1964
                </option>
                <option value="1963" <?php if ($ssc_passingyear == "1963") {
                    echo "selected";
                } ?>>1963
                </option>
                <option value="1962" <?php if ($ssc_passingyear == "1962") {
                    echo "selected";
                } ?>>1962
                </option>
                <option value="1961" <?php if ($ssc_passingyear == "1961") {
                    echo "selected";
                } ?>>1961
                </option>
                <option value="1960" <?php if ($ssc_passingyear == "1960") {
                    echo "selected";
                } ?>>1960
                </option>
                <option value="1959" <?php if ($ssc_passingyear == "1959") {
                    echo "selected";
                } ?>>1959
                </option>
                <option value="1958" <?php if ($ssc_passingyear == "1958") {
                    echo "selected";
                } ?>>1958
                </option>
                <option value="1957" <?php if ($ssc_passingyear == "1957") {
                    echo "selected";
                } ?>>1957
                </option>
                <option value="1956" <?php if ($ssc_passingyear == "1956") {
                    echo "selected";
                } ?>>1956
                </option>
                <option value="1955" <?php if ($ssc_passingyear == "1955") {
                    echo "selected";
                } ?>>1955
                </option>
                <option value="1954" <?php if ($ssc_passingyear == "1954") {
                    echo "selected";
                } ?>>1954
                </option>
                <option value="1953" <?php if ($ssc_passingyear == "1953") {
                    echo "selected";
                } ?>>1953
                </option>
                <option value="1952" <?php if ($ssc_passingyear == "1952") {
                    echo "selected";
                } ?>>1952
                </option>
                <option value="1951" <?php if ($ssc_passingyear == "1951") {
                    echo "selected";
                } ?>>1951
                </option>
                <option value="1950" <?php if ($ssc_passingyear == "1950") {
                    echo "selected";
                } ?>>1950
                </option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <p class="heading-p">10+2 / HSC / PUC / 12th</p>
        <hr>
        <div class="form-group col-md-6">
            <label for="mobile_number">Stream</label><span class="form_error_message">*</span>
            <select name="hsc_stream" id="stream_input_id" class="form-control select">
                <option value="" selected="selected">
                    Select
                    Stream
                </option>
                <option value="Science Stream" <?php if ($hsc_stream == "Science Stream") {
                    echo "selected";
                } ?>>
                    Science
                    Stream</option>
                <option value="Commerce Stream" <?php if ($hsc_stream == "Commerce Stream") {
                    echo "selected";
                } ?>>
                    Commerce
                    Stream
                </option>
                <option value="Arts Stream" <?php if ($hsc_stream == "Arts Stream") {
                    echo "selected";
                } ?>>Arts
                    Stream
                </option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="email">Board Name</label><span class="form_error_message">*</span>
            <select name="hsc_passingboard" id="board_name_input_id" class="form-control select2me">
                <option selected="selected" value="">
                    Select Board Name
                </option>
                <option value="Gujarat Board" <?php if ($hsc_passingboard == "Gujarat Board") {
                    echo "selected";
                } ?>>
                    Gujarat Board
                </option>
                <option value="CBSE" <?php if ($hsc_passingboard == "CBSE") {
                    echo "selected";
                } ?>>CBSE</option>
                <option value="ISCE" <?php if ($hsc_passingboard == "ISCE") {
                    echo "selected";
                } ?>>ISCE
                </option>
                <option value="NIOS" <?php if ($hsc_passingboard == "NIOS") {
                    echo "selected";
                } ?>>NIOS
                </option>
                <option value="IB" <?php if ($hsc_passingboard == "IB") {
                    echo "selected";
                } ?>>IB
                </option>
                <option value="Andhra Pradesh Board of Intermediate Education" <?php if
                ($hsc_passingboard == "Andhra Pradesh Board of Intermediate Education") {
                    echo "selected";
                } ?>>Andhra Pradesh Board of
                    Intermediate
                    Education
                </option>
                <option value="Andhra Pradesh Board of Secondary Education" <?php if
                ($hsc_passingboard == "Andhra Pradesh Board of Secondary Education") {
                    echo "selected";
                } ?>>Andhra
                    Pradesh Board of Secondary Education
                </option>
                <option value="Assam Board of Secondary Education" <?php if
                ($hsc_passingboard == "Assam Board of Secondary Education") {
                    echo "selected";
                } ?>>
                    Assam Board of Secondary Education
                </option>
                <option value="Bihar Intermediate Education Council" <?php if
                ($hsc_passingboard == "Bihar Intermediate Education Council") {
                    echo "selected";
                } ?>>Bihar
                    Intermediate Education Council
                </option>
                <option value="Bihar School Examination Board" <?php if
                ($hsc_passingboard == "Bihar School Examination Board") {
                    echo "selected";
                } ?>>Bihar
                    School Examination Board
                </option>
                <option value="Board of Higher Secondary Education,New Delhi" <?php if
                ($hsc_passingboard == "Board of Higher Secondary Education,New Delhi") {
                    echo "selected";
                } ?>>Board
                    of Higher Secondary Education,New
                    Delhi
                </option>
                <option value="Board of School Education, Haryana" <?php if
                ($hsc_passingboard == "Board of School Education, Haryana") {
                    echo "selected";
                } ?>>
                    Board of School Education, Haryana
                </option>
                <option value="Board of Secondary Education Kant Shahjahanpur Uttar Pradesh" <?php if
                ($hsc_passingboard == "Board of Secondary Education Kant Shahjahanpur Uttar Pradesh") {
                    echo "selected";
                } ?>>Board of Secondary Education Kant
                    Shahjahanpur Uttar
                    Pradesh</option>
                <option value="Board of Secondary Education Madhya Bharat Gwalior" <?php if
                ($hsc_passingboard == "Board of Secondary Education Madhya Bharat Gwalior") {
                    echo "selected";
                } ?>>Board of Secondary
                    Education Madhya Bharat
                    Gwalior
                </option>
                <option value="Board of Secondary Education, Madhya Pradesh" <?php if
                ($hsc_passingboard == "Board of Secondary Education, Madhya Pradesh") {
                    echo "selected";
                } ?>>Board
                    of Secondary Education, Madhya Pradesh
                </option>
                <option value="Board of Secondary Education, Rajasthan" <?php if
                ($hsc_passingboard == "Board of Secondary Education, Rajasthan") {
                    echo "selected";
                } ?>>Board of
                    Secondary Education, Rajasthan </option>
                <option value="Board of Youth Education India" <?php if
                ($hsc_passingboard == "Board of Youth Education India") {
                    echo "selected";
                } ?>>Board
                    of Youth Education India</option>
                <option value="Central Board Of Education Ajmer New Delhi" <?php if
                ($hsc_passingboard == "Central Board Of Education Ajmer New Delhi") {
                    echo "selected";
                } ?>>Central
                    Board Of Education Ajmer New Delhi
                </option>
                <option value="Central Board Of Patna, Bihar" <?php if
                ($hsc_passingboard == "Central Board Of Patna, Bihar") {
                    echo "selected";
                } ?>>
                    Central Board Of Patna, Bihar</option>
                <option value="Chhattisgarh Board of Secondary Education" <?php if
                ($hsc_passingboard == "Chhattisgarh Board of Secondary Education") {
                    echo "selected";
                } ?>>Chhattisgarh Board of Secondary Education
                </option>
                <option value="Goa Board of Secondary & Higher Secondary Education" <?php if
                ($hsc_passingboard == "Goa Board of Secondary & Higher Secondary Education") {
                    echo "selected";
                } ?>>Goa Board of Secondary &
                    Higher Secondary
                    Education
                </option>
                <option value="GSHSEB" <?php if ($hsc_passingboard == "GSHSEB") {
                    echo "selected";
                } ?>>GSHSEB
                </option>
                <option value="Himachal Pradesh Board of School Education" <?php if
                ($hsc_passingboard == "Himachal Pradesh Board of School Education") {
                    echo "selected";
                } ?>>Himachal
                    Pradesh Board of School Education
                </option>
                <option value="Institution of Secondary Distance Education" <?php if
                ($hsc_passingboard == "Institution of Secondary Distance Education") {
                    echo "selected";
                } ?>>Institution of Secondary Distance Education
                </option>
                <option value="J&K State Board of School Education" <?php if
                ($hsc_passingboard == "J&K State Board of School Education") {
                    echo "selected";
                } ?>>
                    J&K State Board of School Education
                </option>
                <option value="Jharkhand Academic Council" <?php if ($hsc_passingboard == "Jharkhand Academic Council") {
                    echo "selected";
                } ?>>Jharkhand
                    Academic Council</option>
                <option value="KARNATAKA PRE-UNIVERSITY EDUCATION EXAMINATION" <?php if
                ($hsc_passingboard == "KARNATAKA PRE-UNIVERSITY EDUCATION EXAMINATION") {
                    echo "selected";
                } ?>>
                    KARNATAKA PRE-UNIVERSITY EDUCATION EXAMINATION</option>
                <option value="Karnataka Board of the Pre-University Education" <?php if
                ($hsc_passingboard == "Karnataka Board of the Pre-University Education") {
                    echo "selected";
                } ?>>Karnataka Board of the
                    Pre-University
                    Education
                </option>
                <option value="Karnataka Secondary Education Examination Board" <?php if
                ($hsc_passingboard == "Karnataka Secondary Education Examination Board") {
                    echo "selected";
                } ?>>Karnataka Secondary Education
                    Examination
                    Board
                </option>
                <option value="Kerala Board of Public Examinations" <?php if
                ($hsc_passingboard == "Kerala Board of Public Examinations") {
                    echo "selected";
                } ?>>
                    Kerala Board of Public Examinations
                </option>
                <option value="Madhya Pradesh State Open School Education Board" <?php if
                ($hsc_passingboard == "Madhya Pradesh State Open School Education Board") {
                    echo "selected";
                } ?>>Madhya Pradesh State Open
                    School Education
                    Board
                </option>
                <option value="Maharashtra State Board of Secondary and Higher Secondary Education" <?php if
                ($hsc_passingboard == "Maharashtra State Board of Secondary and Higher Secondary Education") {
                    echo "selected";
                } ?>>Maharashtra State Board of Secondary and
                    Higher
                    Secondary Education
                </option>
                <option value="Manipur Board of Secondary Education" <?php if
                ($hsc_passingboard == "Manipur Board of Secondary Education") {
                    echo "selected";
                } ?>>Manipur Board
                    of Secondary Education
                </option>
                <option value="Manipur Council of Higher Secondary Education" <?php if
                ($hsc_passingboard == "Manipur Council of Higher Secondary Education") {
                    echo "selected";
                } ?>>Manipur Council of Higher
                    Secondary
                    Education
                </option>
                <option value="Meghalaya Board of School Education" <?php if
                ($hsc_passingboard == "Meghalaya Board of School Education") {
                    echo "selected";
                } ?>>
                    Meghalaya Board of School Education
                </option>
                <option value="Mizoram Board of School Education" <?php if
                ($hsc_passingboard == "Mizoram Board of School Education") {
                    echo "selected";
                } ?>>
                    Mizoram Board of School Education
                </option>
                <option value="Nagaland Board of School Education" <?php if
                ($hsc_passingboard == "Nagaland Board of School Education") {
                    echo "selected";
                } ?>>
                    Nagaland Board of School Education
                </option>
                <option value="Northwest Accreditation Commission & [NWAC]" <?php if
                ($hsc_passingboard == "Northwest Accreditation Commission & [NWAC]") {
                    echo "selected";
                } ?>>Northwest Accreditation Commission &
                    [NWAC]
                </option>
                <option value="Orissa Board of Secondary Education" <?php if
                ($hsc_passingboard == "Orissa Board of Secondary Education") {
                    echo "selected";
                } ?>>
                    Orissa Board of Secondary Education
                </option>
                <option value="Orissa Council of Higher Secondary Education" <?php if
                ($hsc_passingboard == "Orissa Council of Higher Secondary Education") {
                    echo "selected";
                } ?>>Orissa
                    Council of Higher Secondary Education
                </option>
                <option value="Punjab School Education Board" <?php if
                ($hsc_passingboard == "Punjab School Education Board") {
                    echo "selected";
                } ?>>Punjab
                    School Education Board</option>
                <option value="Rajasthan Board of Secondary Education" <?php if
                ($hsc_passingboard == "Rajasthan Board of Secondary Education") {
                    echo "selected";
                } ?>>Rajasthan
                    Board of Secondary Education
                </option>
                <option value="Sampurnanand Sanskrit Vishwavidyalaya Varanasi Uttar Pradesh" <?php if
                ($hsc_passingboard == "Sampurnanand Sanskrit Vishwavidyalaya Varanasi Uttar Pradesh") {
                    echo "selected";
                } ?>>
                    Sampurnanand Sanskrit Vishwavidyalaya Varanasi Uttar
                    Pradesh</option>
                <option value="Tamil Nadu Board of Higher Secondary Education" <?php if
                ($hsc_passingboard == "Tamil Nadu Board of Higher Secondary Education") {
                    echo "selected";
                } ?>>Tamil Nadu Board of Higher Secondary
                    Education
                </option>
                <option value="Tamil Nadu Board of Secondary Education" <?php if
                ($hsc_passingboard == "Tamil Nadu Board of Secondary Education") {
                    echo "selected";
                } ?>>Tamil Nadu
                    Board of Secondary Education
                </option>
                <option value="Tamilnadu Council for Open and Distance Learning" <?php if
                ($hsc_passingboard == "Tamilnadu Council for Open and Distance Learning") {
                    echo "selected";
                } ?>>Tamilnadu Council for Open and
                    Distance
                    Learning
                </option>
                <option value="Telangana State Board of Intermediate Education" <?php if
                ($hsc_passingboard == "Telangana State Board of Intermediate Education") {
                    echo "selected";
                } ?>>Telangana State Board of
                    Intermediate
                    Education
                </option>
                <option value="The West Bengal Council of Rabindra Open Schooling" <?php if
                ($hsc_passingboard == "The West Bengal Council of Rabindra Open Schooling") {
                    echo "selected";
                } ?>>The West Bengal Council
                    of Rabindra Open
                    Schooling
                </option>
                <option value="Tripura Board of Secondary Education" <?php if
                ($hsc_passingboard == "Tripura Board of Secondary Education") {
                    echo "selected";
                } ?>>Tripura Board
                    of Secondary Education
                </option>
                <option value="Uttar Pradesh Board of High School and Intermediate Education" <?php if
                ($hsc_passingboard == "Uttar Pradesh Board of High School and Intermediate Education") {
                    echo "selected";
                } ?>>Uttar Pradesh Board of High School and
                    Intermediate
                    Education</option>
                <option value="Uttarakhand Board of School Education" <?php if
                ($hsc_passingboard == "Uttarakhand Board of School Education") {
                    echo "selected";
                } ?>>
                    Uttarakhand Board of School Education
                </option>
                <option value="H P Board Of School Education" <?php if
                ($hsc_passingboard == "H P Board Of School Education") {
                    echo "selected";
                } ?>>
                    H P Board Of School Education
                </option>
                <option value="J & K State Board Of School Education" <?php if
                ($hsc_passingboard == "J & K State Board Of School Education") {
                    echo "selected";
                } ?>>
                    J & K State Board Of School Education
                </option>
                <option value="West Bengal Board of Secondary Education" <?php if
                ($hsc_passingboard == "West Bengal Board of Secondary Education") {
                    echo "selected";
                } ?>>West
                    Bengal Board of Secondary Education
                </option>
                <option value="West Bengal Council of Higher Secondary Education" <?php if
                ($hsc_passingboard == "West Bengal Council of Higher Secondary Education") {
                    echo "selected";
                } ?>>West Bengal Council of
                    Higher Secondary
                    Education
                </option>
                <option value="West Bengal State Council of Vocational Education and Training" <?php if
                ($hsc_passingboard == "West Bengal State Council of Vocational Education and Training") {
                    echo "selected";
                } ?>>West Bengal State Council of Vocational
                    Education and
                    Training</option>
            </select>
        </div>

    </div>
    <div class="form-row">
        <hr>
        <div class="form-group col-md-6">
            <label for="dob">Seat Number</label><span class="form_error_message">*</span>
            <input value="<?php echo $hsc_boardseatnumber; ?>" name="hsc_boardseatnumber" type="number" maxlength="15"
                id="seat_number_input_id" class="form-control" placeholder="Enter Seat Number" />
        </div>

        <div class="form-group col-md-6">
            <label for="blood_group">Passing Status</label><span class="form_error_message">*</span>
            <select name="hsc_passingstatus" id="status_input_id" class="form-control select">
                <option selected="selected" value="">
                    Select Status
                </option>
                <option value="Pass" <?php if ($hsc_passingstatus == "Pass") {
                    echo "selected";
                } ?>>
                    Pass </option>
                <option value="Pursuing" <?php if ($hsc_passingstatus == "Pursuing") {
                    echo "selected";
                } ?>>
                    Pursuing </option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <hr>
        <div class="form-group col-md-6">
            <label for="religion">School Name</label>
            <input value="<?php echo $hsc_schoolname; ?>" name="hsc_schoolname" type="text" maxlength="250"
                id="school_name_input_id" class="form-control" placeholder="Enter School Name" />
        </div>

        <div class="form-group col-md-6">
            <label for="caste">Aggregate Percentage</label><span class="form_error_message">*</span>
            <input value="<?php echo $hsc_percentage; ?>" name="hsc_percentage" type="number" maxlength="5"
                id="percentage_input_id" class="form-control" placeholder="Enter Aggregate Percentage" />
        </div>

    </div>

    <div class="form-row">

        <div class="form-group col-md-6">
            <label for="adhar">Passing Month</label><span class="form_error_message">*</span>
            <select name="hsc_passingmonth" id="passmon_input_id" class="form-control select2me">
                <option value=""> MM
                </option>
                <option value="01" <?php if ($hsc_passingmonth == "01") {
                    echo "selected";
                } ?>>01</option>
                <option value="02" <?php if ($hsc_passingmonth == "02") {
                    echo "selected";
                } ?>>02</option>
                <option value="03" <?php if ($hsc_passingmonth == "03") {
                    echo "selected";
                } ?>>03</option>
                <option value="04" <?php if ($hsc_passingmonth == "04") {
                    echo "selected";
                } ?>>04</option>
                <option value="05" <?php if ($hsc_passingmonth == "05") {
                    echo "selected";
                } ?>>05</option>
                <option value="06" <?php if ($hsc_passingmonth == "06") {
                    echo "selected";
                } ?>>06</option>
                <option value="07" <?php if ($hsc_passingmonth == "07") {
                    echo "selected";
                } ?>>07</option>
                <option value="08" <?php if ($hsc_passingmonth == "08") {
                    echo "selected";
                } ?>>08</option>
                <option value="09" <?php if ($hsc_passingmonth == "09") {
                    echo "selected";
                } ?>>09</option>
                <option value="10" <?php if ($hsc_passingmonth == "10") {
                    echo "selected";
                } ?>>10
                </option>
                <option value="11" <?php if ($hsc_passingmonth == "11") {
                    echo "selected";
                } ?>>11
                </option>
                <option value="12" <?php if ($hsc_passingmonth == "12") {
                    echo "selected";
                } ?>>12
                </option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="adhar">Passing Year</label><span class="form_error_message">*</span>
            <select name="hsc_passingyear" id="passyear_input_id" class="form-control select2me">
                <option value=""> YYYY
                </option>
                <option value="2023" <?php if ($hsc_passingyear == "2023") {
                    echo "selected";
                } ?>>2023
                </option>
                <option value="2022" <?php if ($hsc_passingyear == "2022") {
                    echo "selected";
                } ?>>2022
                </option>
                <option value="2021" <?php if ($hsc_passingyear == "2021") {
                    echo "selected";
                } ?>>2021
                </option>
                <option value="2020" <?php if ($hsc_passingyear == "2020") {
                    echo "selected";
                } ?>>2020
                </option>
                <option value="2019" <?php if ($hsc_passingyear == "2019") {
                    echo "selected";
                } ?>>2019
                </option>
                <option value="2018" <?php if ($hsc_passingyear == "2018") {
                    echo "selected";
                } ?>>2018
                </option>
                <option value="2017" <?php if ($hsc_passingyear == "2017") {
                    echo "selected";
                } ?>>2017
                </option>
                <option value="2016" <?php if ($hsc_passingyear == "2016") {
                    echo "selected";
                } ?>>2016
                </option>
                <option value="2015" <?php if ($hsc_passingyear == "2015") {
                    echo "selected";
                } ?>>2015
                </option>
                <option value="2014" <?php if ($hsc_passingyear == "2014") {
                    echo "selected";
                } ?>>2014
                </option>
                <option value="2013" <?php if ($hsc_passingyear == "2013") {
                    echo "selected";
                } ?>>2013
                </option>
                <option value="2012" <?php if ($hsc_passingyear == "2012") {
                    echo "selected";
                } ?>>2012
                </option>
                <option value="2011" <?php if ($hsc_passingyear == "2011") {
                    echo "selected";
                } ?>>2011
                </option>
                <option value="2010" <?php if ($hsc_passingyear == "2010") {
                    echo "selected";
                } ?>>2010
                </option>
                <option value="2009" <?php if ($hsc_passingyear == "2009") {
                    echo "selected";
                } ?>>2009
                </option>
                <option value="2008" <?php if ($hsc_passingyear == "2008") {
                    echo "selected";
                } ?>>2008
                </option>
                <option value="2007" <?php if ($hsc_passingyear == "2007") {
                    echo "selected";
                } ?>>2007
                </option>
                <option value="2006" <?php if ($hsc_passingyear == "2006") {
                    echo "selected";
                } ?>>2006
                </option>
                <option value="2005" <?php if ($hsc_passingyear == "2005") {
                    echo "selected";
                } ?>>2005
                </option>
                <option value="2004" <?php if ($hsc_passingyear == "2004") {
                    echo "selected";
                } ?>>2004
                </option>
                <option value="2003" <?php if ($hsc_passingyear == "2003") {
                    echo "selected";
                } ?>>2003
                </option>
                <option value="2002" <?php if ($hsc_passingyear == "2002") {
                    echo "selected";
                } ?>>2002
                </option>
                <option value="2001" <?php if ($hsc_passingyear == "2001") {
                    echo "selected";
                } ?>>2001
                </option>
                <option value="2000" <?php if ($hsc_passingyear == "2000") {
                    echo "selected";
                } ?>>2000
                </option>
                <option value="1999" <?php if ($hsc_passingyear == "1999") {
                    echo "selected";
                } ?>>1999
                </option>
                <option value="1998" <?php if ($hsc_passingyear == "1998") {
                    echo "selected";
                } ?>>1998
                </option>
                <option value="1997" <?php if ($hsc_passingyear == "1997") {
                    echo "selected";
                } ?>>1997
                </option>
                <option value="1996" <?php if ($hsc_passingyear == "1996") {
                    echo "selected";
                } ?>>1996
                </option>
                <option value="1995" <?php if ($hsc_passingyear == "1995") {
                    echo "selected";
                } ?>>1995
                </option>
                <option value="1994" <?php if ($hsc_passingyear == "1994") {
                    echo "selected";
                } ?>>1994
                </option>
                <option value="1993" <?php if ($hsc_passingyear == "1993") {
                    echo "selected";
                } ?>>1993
                </option>
                <option value="1992" <?php if ($hsc_passingyear == "1992") {
                    echo "selected";
                } ?>>1992
                </option>
                <option value="1991" <?php if ($hsc_passingyear == "1991") {
                    echo "selected";
                } ?>>1991
                </option>
                <option value="1990" <?php if ($hsc_passingyear == "1990") {
                    echo "selected";
                } ?>>1990
                </option>
                <option value="1989" <?php if ($hsc_passingyear == "1989") {
                    echo "selected";
                } ?>>1989
                </option>
                <option value="1988" <?php if ($hsc_passingyear == "1988") {
                    echo "selected";
                } ?>>1988
                </option>
                <option value="1987" <?php if ($hsc_passingyear == "1987") {
                    echo "selected";
                } ?>>1987
                </option>
                <option value="1986" <?php if ($hsc_passingyear == "1986") {
                    echo "selected";
                } ?>>1986
                </option>
                <option value="1985" <?php if ($hsc_passingyear == "1985") {
                    echo "selected";
                } ?>>1985
                </option>
                <option value="1984" <?php if ($hsc_passingyear == "1984") {
                    echo "selected";
                } ?>>1984
                </option>
                <option value="1983" <?php if ($hsc_passingyear == "1983") {
                    echo "selected";
                } ?>>1983
                </option>
                <option value="1982" <?php if ($hsc_passingyear == "1982") {
                    echo "selected";
                } ?>>1982
                </option>
                <option value="1981" <?php if ($hsc_passingyear == "1981") {
                    echo "selected";
                } ?>>1981
                </option>
                <option value="1980" <?php if ($hsc_passingyear == "1980") {
                    echo "selected";
                } ?>>1980
                </option>
                <option value="1979" <?php if ($hsc_passingyear == "1979") {
                    echo "selected";
                } ?>>1979
                </option>
                <option value="1978" <?php if ($hsc_passingyear == "1978") {
                    echo "selected";
                } ?>>1978
                </option>
                <option value="1977" <?php if ($hsc_passingyear == "1977") {
                    echo "selected";
                } ?>>1977
                </option>
                <option value="1976" <?php if ($hsc_passingyear == "1976") {
                    echo "selected";
                } ?>>1976
                </option>
                <option value="1975" <?php if ($hsc_passingyear == "1975") {
                    echo "selected";
                } ?>>1975
                </option>
                <option value="1974" <?php if ($hsc_passingyear == "1974") {
                    echo "selected";
                } ?>>1974
                </option>
                <option value="1973" <?php if ($hsc_passingyear == "1973") {
                    echo "selected";
                } ?>>1973
                </option>
                <option value="1972" <?php if ($hsc_passingyear == "1972") {
                    echo "selected";
                } ?>>1972
                </option>
                <option value="1971" <?php if ($hsc_passingyear == "1971") {
                    echo "selected";
                } ?>>1971
                </option>
                <option value="1970" <?php if ($hsc_passingyear == "1970") {
                    echo "selected";
                } ?>>1970
                </option>
                <option value="1969" <?php if ($hsc_passingyear == "1969") {
                    echo "selected";
                } ?>>1969
                </option>
                <option value="1968" <?php if ($hsc_passingyear == "1968") {
                    echo "selected";
                } ?>>1968
                </option>
                <option value="1967" <?php if ($hsc_passingyear == "1967") {
                    echo "selected";
                } ?>>1967
                </option>
                <option value="1966" <?php if ($hsc_passingyear == "1966") {
                    echo "selected";
                } ?>>1966
                </option>
                <option value="1965" <?php if ($hsc_passingyear == "1965") {
                    echo "selected";
                } ?>>1965
                </option>
                <option value="1964" <?php if ($hsc_passingyear == "1964") {
                    echo "selected";
                } ?>>1964
                </option>
                <option value="1963" <?php if ($hsc_passingyear == "1963") {
                    echo "selected";
                } ?>>1963
                </option>
                <option value="1962" <?php if ($hsc_passingyear == "1962") {
                    echo "selected";
                } ?>>1962
                </option>
                <option value="1961" <?php if ($hsc_passingyear == "1961") {
                    echo "selected";
                } ?>>1961
                </option>
                <option value="1960" <?php if ($hsc_passingyear == "1960") {
                    echo "selected";
                } ?>>1960
                </option>
                <option value="1959" <?php if ($hsc_passingyear == "1959") {
                    echo "selected";
                } ?>>1959
                </option>
                <option value="1958" <?php if ($hsc_passingyear == "1958") {
                    echo "selected";
                } ?>>1958
                </option>
                <option value="1957" <?php if ($hsc_passingyear == "1957") {
                    echo "selected";
                } ?>>1957
                </option>
                <option value="1956" <?php if ($hsc_passingyear == "1956") {
                    echo "selected";
                } ?>>1956
                </option>
                <option value="1955" <?php if ($hsc_passingyear == "1955") {
                    echo "selected";
                } ?>>1955
                </option>
                <option value="1954" <?php if ($hsc_passingyear == "1954") {
                    echo "selected";
                } ?>>1954
                </option>
                <option value="1953" <?php if ($hsc_passingyear == "1953") {
                    echo "selected";
                } ?>>1953
                </option>
                <option value="1952" <?php if ($hsc_passingyear == "1952") {
                    echo "selected";
                } ?>>1952
                </option>
                <option value="1951" <?php if ($hsc_passingyear == "1951") {
                    echo "selected";
                } ?>>1951
                </option>
                <option value="1950" <?php if ($hsc_passingyear == "1950") {
                    echo "selected";
                } ?>>1950
                </option>
            </select>
        </div>

    </div>

    <?php
    if ($stu_faculty_id == 1 || $stu_faculty_id == 15) {
        ?>

        <div class="form-row">
            <p class="heading-p">Competitive Exam Details</p>
            <hr>
            <script>
                function gujcet_appearCheck() {
                    if (document.getElementById('gujcet_appear_yes').checked) {
                        document.getElementById('ifgujcetyes').style.visibility = 'visible';
                    } else {
                        document.getElementById('ifgujcetyes').style.visibility = 'hidden';
                    }
                }
            </script>
            <div class="form-group col-md-4">
                <label for="father">GUJCET Appearance</label><span class="form_error_message">*</span>
                <input onclick="javascript:gujcet_appearCheck();" value="Yes" <?php if ($gujcet_appear == "Yes") {
                    echo "checked";
                } ?> name="gujcet_appear" id="gujcet_appear_yes" type="radio">
                Yes
                <input onclick="javascript:gujcet_appearCheck();" value="No" <?php if ($gujcet_appear == "No") {
                    echo "checked";
                } ?> name="gujcet_appear" id="gujcet_appear_no" type="radio">
                No
            </div>

            <div class="form-group col-md-4">
                <label for="father">Seat Number</label>
                <input value="<?php echo $gujcet_seatnumber; ?>" name="gujcet_seatnumber" type="number" maxlength="25"
                    id="seat_number_input_id" class="form-control" placeholder="Enter Seat Number" />
            </div>

            <div class="form-group col-md-4">
                <label for="mother">Application Number</label>
                <input value="<?php echo $gujcet_applicationnumber; ?>" name="gujcet_applicationnumber" type="number"
                    maxlength="25" id="application_number_input_id" class="form-control"
                    placeholder="Enter Application Number" />
            </div>
        </div>
        <div class="form-row">
            <script>
                function neet_appearCheck() {
                    if (document.getElementById('neet_appear_yes').checked) {
                        document.getElementById('ifneetyes').style.visibility = 'visible';
                    } else {
                        document.getElementById('ifneetyes').style.visibility = 'hidden';
                    }
                }
            </script>
            <div class="form-group col-md-4">
                <label for="father_occupation">NEET Appearance</label><span class="form_error_message">*</span>
                <input onclick="javascript:neet_appearCheck();" value="Yes" <?php if ($neet_appear == "Yes") {
                    echo "checked"
                    ;
                } ?> name="neet_appear" id="neet_appear_yes" type="radio">
                Yes
                <input onclick="javascript:neet_appearCheck();" value="No" <?php if ($neet_appear == "No") {
                    echo "checked";
                } ?> name="neet_appear" id="neet_appear_no" type="radio">
                No
            </div>

            <div class="form-group col-md-4">
                <label for="father_occupation">Seat Number</label>
                <input value="<?php echo $neet_seatnumber; ?>" name="neet_seatnumber" type="number" maxlength="25"
                    id="seat_number_input_id" class="form-control" placeholder="Enter Seat Number" />
            </div>

            <div class="form-group col-md-4">
                <label for="mother_occupation">Application Number</label>
                <input value="<?php echo $neet_applicationnumber; ?>" name="neet_applicationnumber" type="number"
                    maxlength="25" id="application_number_input_id" class="form-control"
                    placeholder="Enter Application Number" />
            </div>
        </div>
        <div class="form-row">
            <script>
                function jee_appearCheck() {
                    if (document.getElementById('jee_appear_yes').checked) {
                        document.getElementById('ifjeeyes').style.visibility = 'visible';
                    } else {
                        document.getElementById('ifjeeyes').style.visibility = 'hidden';
                    }
                }
            </script>
            <div class="form-group col-md-4">
                <label for="parents_number">JEE Appearance</label><span class="form_error_message">*</span>
                <input onclick="javascript:jee_appearCheck();" value="Yes" <?php if ($jee_appear == "Yes") {
                    echo "checked";
                } ?> name="jee_appear" id="jee_appear_yes" type="radio">
                Yes
                <input onclick="javascript:jee_appearCheck();" value="No" <?php if ($jee_appear == "No") {
                    echo "checked";
                }
                ?> name="jee_appear" id="jee_appear_no" type="radio"> No
            </div>

            <div class="form-group col-md-4">
                <label for="parents_number">Seat Number</label>
                <input value="<?php echo $jee_seatnumber; ?>" name="jee_seatnumber" type="number" maxlength="25"
                    id="seat_number_input_id" class="form-control" placeholder="Enter Seat Number" />
            </div>

            <div class="form-group col-md-4">
                <label for="parents_email">Application Number</label>
                <input value="<?php echo $jee_applicationnumber; ?>" name="jee_applicationnumber" type="number"
                    maxlength="25" id="application_number_input_id" class="form-control"
                    placeholder="Enter Application Number" />
            </div>

        </div>
        <?php

    }
    ?>
    <?php
    if ($stu_level_id == 2 || $stu_level_id == 4) {
        ?>

        <div class="form-row">
            <p class="heading-p">Graduation Details</p>
            <hr>
            <div class="form-group col-md-4">
                <label for="address">Graduation Course</label><span class="form_error_message">*</span>
                <input value="<?php echo $graduation_course; ?>" name="graduation_course" type="text" maxlength="250"
                    id="course_input_id" class="form-control" placeholder="Enter Graduation Course" />
            </div>
            <div class="form-group col-md-4">
                <label for="pincode">University</label><span class="form_error_message">*</span>
                <input value="<?php echo $graduation_university; ?>" name="graduation_university" type="text" maxlength="25"
                    id="seat_number_input_id" class="form-control" placeholder="Select University Name" />
            </div>
            <div class="form-group col-md-4">
                <label for="pincode">College Name</label><span class="form_error_message">*</span>
                <input value="<?php echo $graduation_college_name; ?>" name="graduation_college_name" type="text"
                    maxlength="25" id="college_name_input_id" class="form-control" placeholder="Enter College Name" />
            </div>

        </div>
        <div class="form-row">
            <hr>
            <div class="form-group col-md-6">
                <label for="religion">Result/Percentage/CPI</label>
                <input value="<?php echo $graduation_cpi; ?>" name="graduation_cpi" type="number" maxlength="5"
                    id="percentage_input_id" class="form-control" placeholder="Enter Aggregate Percentage" />
            </div>

            <div class="form-group col-md-6">
                <label for="caste">Passing Status</label><span class="form_error_message">*</span>
                <select name="graduation_passing_status" id="status_input_id" class="form-control select">
                    <option selected="selected" value="">
                        Select Status
                    </option>
                    <option value="Pass" <?php if ($graduation_passing_status == "Pass") {
                        echo "selected";
                    } ?>>
                        Pass </option>
                    <option value="Pursuing" <?php if ($graduation_passing_status == "Pursuing") {
                        echo "selected";
                    } ?>>
                        Pursuing </option>
                </select>
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="permanent_address">Passing Month</label><span class="form_error_message">*</span>

                <select name="graduation_passing_month" id="passmon_input_id" class="form-control select2me">
                    <option value=""> MM
                    </option>
                    <option value="01" <?php if ($graduation_passing_month == "01") {
                        echo "selected";
                    } ?>>01</option>
                    <option value="02" <?php if ($graduation_passing_month == "02") {
                        echo "selected";
                    } ?>>02</option>
                    <option value="03" <?php if ($graduation_passing_month == "03") {
                        echo "selected";
                    } ?>>03</option>
                    <option value="04" <?php if ($graduation_passing_month == "04") {
                        echo "selected";
                    } ?>>04</option>
                    <option value="05" <?php if ($graduation_passing_month == "05") {
                        echo "selected";
                    } ?>>05</option>
                    <option value="06" <?php if ($graduation_passing_month == "06") {
                        echo "selected";
                    } ?>>06</option>
                    <option value="07" <?php if ($graduation_passing_month == "07") {
                        echo "selected";
                    } ?>>07</option>
                    <option value="08" <?php if ($graduation_passing_month == "08") {
                        echo "selected";
                    } ?>>08</option>
                    <option value="09" <?php if ($graduation_passing_month == "09") {
                        echo "selected";
                    } ?>>09</option>
                    <option value="10" <?php if ($graduation_passing_month == "10") {
                        echo "selected";
                    } ?>>10
                    </option>
                    <option value="11" <?php if ($graduation_passing_month == "11") {
                        echo "selected";
                    } ?>>11
                    </option>
                    <option value="12" <?php if ($graduation_passing_month == "12") {
                        echo "selected";
                    } ?>>12
                    </option>
                </select>
            </div>
            <div class="form-group col-md-6">
                <label for="permanent_pincode">Passing Year</label><span class="form_error_message">*</span>
                <select name="graduation_passing_year" id="passyear_input_id" class="form-control select2me">
                    <option value=""> YYYY
                    </option>
                    <option value="2023" <?php if ($graduation_passing_year == "2023") {
                        echo "selected";
                    } ?>>2023
                    </option>
                    <option value="2022" <?php if ($graduation_passing_year == "2022") {
                        echo "selected";
                    } ?>>2022
                    </option>
                    <option value="2021" <?php if ($graduation_passing_year == "2021") {
                        echo "selected";
                    } ?>>2021
                    </option>
                    <option value="2020" <?php if ($graduation_passing_year == "2020") {
                        echo "selected";
                    } ?>>2020
                    </option>
                    <option value="2019" <?php if ($graduation_passing_year == "2019") {
                        echo "selected";
                    } ?>>2019
                    </option>
                    <option value="2018" <?php if ($graduation_passing_year == "2018") {
                        echo "selected";
                    } ?>>2018
                    </option>
                    <option value="2017" <?php if ($graduation_passing_year == "2017") {
                        echo "selected";
                    } ?>>2017
                    </option>
                    <option value="2016" <?php if ($graduation_passing_year == "2016") {
                        echo "selected";
                    } ?>>2016
                    </option>
                    <option value="2015" <?php if ($graduation_passing_year == "2015") {
                        echo "selected";
                    } ?>>2015
                    </option>
                    <option value="2014" <?php if ($graduation_passing_year == "2014") {
                        echo "selected";
                    } ?>>2014
                    </option>
                    <option value="2013" <?php if ($graduation_passing_year == "2013") {
                        echo "selected";
                    } ?>>2013
                    </option>
                    <option value="2012" <?php if ($graduation_passing_year == "2012") {
                        echo "selected";
                    } ?>>2012
                    </option>
                    <option value="2011" <?php if ($graduation_passing_year == "2011") {
                        echo "selected";
                    } ?>>2011
                    </option>
                    <option value="2010" <?php if ($graduation_passing_year == "2010") {
                        echo "selected";
                    } ?>>2010
                    </option>
                    <option value="2009" <?php if ($graduation_passing_year == "2009") {
                        echo "selected";
                    } ?>>2009
                    </option>
                    <option value="2008" <?php if ($graduation_passing_year == "2008") {
                        echo "selected";
                    } ?>>2008
                    </option>
                    <option value="2007" <?php if ($graduation_passing_year == "2007") {
                        echo "selected";
                    } ?>>2007
                    </option>
                    <option value="2006" <?php if ($graduation_passing_year == "2006") {
                        echo "selected";
                    } ?>>2006
                    </option>
                    <option value="2005" <?php if ($graduation_passing_year == "2005") {
                        echo "selected";
                    } ?>>2005
                    </option>
                    <option value="2004" <?php if ($graduation_passing_year == "2004") {
                        echo "selected";
                    } ?>>2004
                    </option>
                    <option value="2003" <?php if ($graduation_passing_year == "2003") {
                        echo "selected";
                    } ?>>2003
                    </option>
                    <option value="2002" <?php if ($graduation_passing_year == "2002") {
                        echo "selected";
                    } ?>>2002
                    </option>
                    <option value="2001" <?php if ($graduation_passing_year == "2001") {
                        echo "selected";
                    } ?>>2001
                    </option>
                    <option value="2000" <?php if ($graduation_passing_year == "2000") {
                        echo "selected";
                    } ?>>2000
                    </option>
                    <option value="1999" <?php if ($graduation_passing_year == "1999") {
                        echo "selected";
                    } ?>>1999
                    </option>
                    <option value="1998" <?php if ($graduation_passing_year == "1998") {
                        echo "selected";
                    } ?>>1998
                    </option>
                    <option value="1997" <?php if ($graduation_passing_year == "1997") {
                        echo "selected";
                    } ?>>1997
                    </option>
                    <option value="1996" <?php if ($graduation_passing_year == "1996") {
                        echo "selected";
                    } ?>>1996
                    </option>
                    <option value="1995" <?php if ($graduation_passing_year == "1995") {
                        echo "selected";
                    } ?>>1995
                    </option>
                    <option value="1994" <?php if ($graduation_passing_year == "1994") {
                        echo "selected";
                    } ?>>1994
                    </option>
                    <option value="1993" <?php if ($graduation_passing_year == "1993") {
                        echo "selected";
                    } ?>>1993
                    </option>
                    <option value="1992" <?php if ($graduation_passing_year == "1992") {
                        echo "selected";
                    } ?>>1992
                    </option>
                    <option value="1991" <?php if ($graduation_passing_year == "1991") {
                        echo "selected";
                    } ?>>1991
                    </option>
                    <option value="1990" <?php if ($graduation_passing_year == "1990") {
                        echo "selected";
                    } ?>>1990
                    </option>
                    <option value="1989" <?php if ($graduation_passing_year == "1989") {
                        echo "selected";
                    } ?>>1989
                    </option>
                    <option value="1988" <?php if ($graduation_passing_year == "1988") {
                        echo "selected";
                    } ?>>1988
                    </option>
                    <option value="1987" <?php if ($graduation_passing_year == "1987") {
                        echo "selected";
                    } ?>>1987
                    </option>
                    <option value="1986" <?php if ($graduation_passing_year == "1986") {
                        echo "selected";
                    } ?>>1986
                    </option>
                    <option value="1985" <?php if ($graduation_passing_year == "1985") {
                        echo "selected";
                    } ?>>1985
                    </option>
                    <option value="1984" <?php if ($graduation_passing_year == "1984") {
                        echo "selected";
                    } ?>>1984
                    </option>
                    <option value="1983" <?php if ($graduation_passing_year == "1983") {
                        echo "selected";
                    } ?>>1983
                    </option>
                    <option value="1982" <?php if ($graduation_passing_year == "1982") {
                        echo "selected";
                    } ?>>1982
                    </option>
                    <option value="1981" <?php if ($graduation_passing_year == "1981") {
                        echo "selected";
                    } ?>>1981
                    </option>
                    <option value="1980" <?php if ($graduation_passing_year == "1980") {
                        echo "selected";
                    } ?>>1980
                    </option>
                    <option value="1979" <?php if ($graduation_passing_year == "1979") {
                        echo "selected";
                    } ?>>1979
                    </option>
                    <option value="1978" <?php if ($graduation_passing_year == "1978") {
                        echo "selected";
                    } ?>>1978
                    </option>
                    <option value="1977" <?php if ($graduation_passing_year == "1977") {
                        echo "selected";
                    } ?>>1977
                    </option>
                    <option value="1976" <?php if ($graduation_passing_year == "1976") {
                        echo "selected";
                    } ?>>1976
                    </option>
                    <option value="1975" <?php if ($graduation_passing_year == "1975") {
                        echo "selected";
                    } ?>>1975
                    </option>
                    <option value="1974" <?php if ($graduation_passing_year == "1974") {
                        echo "selected";
                    } ?>>1974
                    </option>
                    <option value="1973" <?php if ($graduation_passing_year == "1973") {
                        echo "selected";
                    } ?>>1973
                    </option>
                    <option value="1972" <?php if ($graduation_passing_year == "1972") {
                        echo "selected";
                    } ?>>1972
                    </option>
                    <option value="1971" <?php if ($graduation_passing_year == "1971") {
                        echo "selected";
                    } ?>>1971
                    </option>
                    <option value="1970" <?php if ($graduation_passing_year == "1970") {
                        echo "selected";
                    } ?>>1970
                    </option>
                    <option value="1969" <?php if ($graduation_passing_year == "1969") {
                        echo "selected";
                    } ?>>1969
                    </option>
                    <option value="1968" <?php if ($graduation_passing_year == "1968") {
                        echo "selected";
                    } ?>>1968
                    </option>
                    <option value="1967" <?php if ($graduation_passing_year == "1967") {
                        echo "selected";
                    } ?>>1967
                    </option>
                    <option value="1966" <?php if ($graduation_passing_year == "1966") {
                        echo "selected";
                    } ?>>1966
                    </option>
                    <option value="1965" <?php if ($graduation_passing_year == "1965") {
                        echo "selected";
                    } ?>>1965
                    </option>
                    <option value="1964" <?php if ($graduation_passing_year == "1964") {
                        echo "selected";
                    } ?>>1964
                    </option>
                    <option value="1963" <?php if ($graduation_passing_year == "1963") {
                        echo "selected";
                    } ?>>1963
                    </option>
                    <option value="1962" <?php if ($graduation_passing_year == "1962") {
                        echo "selected";
                    } ?>>1962
                    </option>
                    <option value="1961" <?php if ($graduation_passing_year == "1961") {
                        echo "selected";
                    } ?>>1961
                    </option>
                    <option value="1960" <?php if ($graduation_passing_year == "1960") {
                        echo "selected";
                    } ?>>1960
                    </option>
                    <option value="1959" <?php if ($graduation_passing_year == "1959") {
                        echo "selected";
                    } ?>>1959
                    </option>
                    <option value="1958" <?php if ($graduation_passing_year == "1958") {
                        echo "selected";
                    } ?>>1958
                    </option>
                    <option value="1957" <?php if ($graduation_passing_year == "1957") {
                        echo "selected";
                    } ?>>1957
                    </option>
                    <option value="1956" <?php if ($graduation_passing_year == "1956") {
                        echo "selected";
                    } ?>>1956
                    </option>
                    <option value="1955" <?php if ($graduation_passing_year == "1955") {
                        echo "selected";
                    } ?>>1955
                    </option>
                    <option value="1954" <?php if ($graduation_passing_year == "1954") {
                        echo "selected";
                    } ?>>1954
                    </option>
                    <option value="1953" <?php if ($graduation_passing_year == "1953") {
                        echo "selected";
                    } ?>>1953
                    </option>
                    <option value="1952" <?php if ($graduation_passing_year == "1952") {
                        echo "selected";
                    } ?>>1952
                    </option>
                    <option value="1951" <?php if ($graduation_passing_year == "1951") {
                        echo "selected";
                    } ?>>1951
                    </option>
                    <option value="1950" <?php if ($graduation_passing_year == "1950") {
                        echo "selected";
                    } ?>>1950
                    </option>
                </select>
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="permanent_address">GMCET Score</label>
                <input value="<?php echo $gmcet_score; ?>" name="gmcet_score" type="text" maxlength="5"
                    id="percentage_input_id" class="form-control" placeholder="Enter Score" />
            </div>
            <div class="form-group col-md-6">
                <label for="permanent_pincode">CMAT Score</label>
                <input value="<?php echo $cmat_score; ?>" name="cmat_score" type="text" maxlength="5"
                    id="percentage_input_id" class="form-control" placeholder="Enter Score" />
            </div>

        </div>
        <?php
    }
    ?>

</form>