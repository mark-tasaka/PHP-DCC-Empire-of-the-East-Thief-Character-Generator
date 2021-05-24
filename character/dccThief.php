<!DOCTYPE html>
<html>
<head>
<title>DCC Empire of the East Thief Character Generator </title>
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
	<meta charset="UTF-8">
	<meta name="description" content="Dungeon Crawl Classics thief Character Generator..">
	<meta name="keywords" content="Dungeon Crawl Classics,,HTML5,CSS,JavaScript">
	<meta name="author" content="Mark Tasaka 2021">
    
    <link rel="icon" href="../../../../images/favicon/icon.png" type="image/png" sizes="16x16"> 
		

	<link rel="stylesheet" type="text/css" href="css/thief.css">
    
    
    
    
</head>
<body>
    
    <!--PHP-->
    <?php
    
    include 'php/armour.php';
    include 'php/checks.php';
    include 'php/weapons.php';
    include 'php/gear.php';
    include 'php/classDetails.php';
    include 'php/abilityScoreGen.php';
    include 'php/randomName.php';
    include 'php/thiefAbilities.php';
    include 'php/xp.php';
    include 'php/diceRoll.php';
    include 'php/luckySign.php';
    include 'php/zeroLvOccupation.php';
    

        if(isset($_POST["theCharacterName"]))
        {
            $characterName = $_POST["theCharacterName"];
    
        }

        
        if(isset($_POST["thePlayerName"]))
        {
            $playerName = $_POST["thePlayerName"];
    
        }
        
        
        if(isset($_POST["theGender"]))
        {
            $gender = $_POST["theGender"];
        }


        if(isset($_POST['theCheckBoxRandomName']) && $_POST['theCheckBoxRandomName'] == 1) 
        {
            $characterName = getRandomName($gender) . " " . getSurname();
        } 

        if(isset($_POST["theAlignment"]))
        {
            $alignment = $_POST["theAlignment"];
        }
    
        if(isset($_POST["theLevel"]))
        {
            $level = $_POST["theLevel"];
        
        } 

        
        $xpNextLevel = getXPNextLevel ($level);
        
        if(isset($_POST["theAbilityScore"]))
        {
            $abilityScoreGen = $_POST["theAbilityScore"];
        
        } 

        
        $abilityScoreArray = array();
        
        for($i = 0; $i < 6; ++$i)
        {
            $abilityScore = rollAbilityScores ($abilityScoreGen);

            array_push($abilityScoreArray, $abilityScore);

        }       

        $strength = $abilityScoreArray[0];
        $agility = $abilityScoreArray[1];
        $stamina = $abilityScoreArray[2];
        $personality = $abilityScoreArray[3];
        $intelligence = $abilityScoreArray[4];
        $luck = $abilityScoreArray[5];
        
        $strengthMod = getAbilityModifier($strength);
        $agilityMod = getAbilityModifier($agility);
        $staminaMod = getAbilityModifier($stamina);
        $personalityMod = getAbilityModifier($personality);
        $intelligenceMod = getAbilityModifier($intelligence);
        $luckMod = getAbilityModifier($luck);


    $generationMessage = generationMesssage ($abilityScoreGen);
    
    
        if(isset($_POST["theArmour"]))
        {
            $armour = $_POST["theArmour"];
        }
    
        $armourName = getArmour($armour)[0];
        
        $armourACBonus = getArmour($armour)[1];
        $armourCheckPen = getArmour($armour)[2];
        $armourSpeedPen = getArmour($armour)[3];
        $armourFumbleDie = getArmour($armour)[4];

        if(isset($_POST['theCheckBoxShield']) && $_POST['theCheckBoxShield'] == 1) 
        {
            $shieldName = getArmour(10)[0];
            $shieldACBonus = getArmour(10)[1];
            $shieldCheckPen = getArmour(10)[2];
            $shieldSpeedPen = getArmour(10)[3];
            $shieldFumbleDie = getArmour(10)[4];
        }
        else
        {
            $shieldName = getArmour(11)[0];
            $shieldACBonus = getArmour(11)[1];
            $shieldCheckPen = getArmour(11)[2];
            $shieldSpeedPen = getArmour(11)[3];
            $shieldFumbleDie = getArmour(11)[4];
        } 

       $totalAcDefense = $armourACBonus + $shieldACBonus;
       $totalAcCheckPen = $armourCheckPen + $shieldCheckPen;
       $speedPenality = $armourSpeedPen;

       $speed = 30 - $armourSpeedPen;

       $reflexBase = savingThrowReflex($level);
       $fortBase = savingThrowFort($level);
       $willBase = savingThrowWill($level);

       $criticalDie = criticalDie($level);

       $luckDie = luckDie($level);

       $actionDice = actionDice($level);

       $attackBonus = attackBonus ($level);


       $title = title($level, $alignment);

       
       $professionNum = getOccupationNumber(); 
        
       $occupationArray = array();
       
       $occupationArray = getOccupationArray($professionNum);
       
       $profession = $occupationArray[0];


       $trainedWeapon = $occupationArray[1];

       //tradegoods array

       $tradegoods = array();

       array_push($tradegoods, $occupationArray[3]);

       if($occupationArray[4] != '')
       {
            array_push($tradegoods, ', ');
            array_push($tradegoods, $occupationArray[4]);

       }


       $backstabArray = getBackstabArray ($alignment);
       $backstab = $backstabArray[$level];

       $sneakSilentlyArray = getSneakSilentlyArray ($alignment);
       $sneakSilently = $sneakSilentlyArray[$level];

       $hideInShadowArray = getHideInShadowsArray ($alignment);
       $hideInShadows = $hideInShadowArray[$level];

       $pickPocketArray = getHideInShadowsArray ($alignment);
       $pickPocket = $pickPocketArray[$level];

       $climbArray = getClimbArray ($alignment);
       $climb = $climbArray[$level];

       $pickLockArray = getPickLockArray ($alignment);
       $pickLock = $pickLockArray[$level];

       $findTrapArray = getFindTrapArray ($alignment);
       $findTrap = $findTrapArray[$level];

       $disableTrapArray = getDisableTrapArray ($alignment);
       $disableTrap = $disableTrapArray[$level];

       $forgeDocArray = getForgeDocArray ($alignment);
       $forgeDoc = $forgeDocArray[$level];

       $disguiseSelfArray = getDisguiseSelfArray ($alignment);
       $disguiseSelf = $disguiseSelfArray[$level];

       $readLanguagesArray = getReadLanguagesArray ($alignment);
       $readLanguages = $readLanguagesArray[$level];

       $handlePoisonArray = getHandlePoisonArray ($alignment);
       $handlePoison = $handlePoisonArray[$level];

       $castSpellScrollArray = getCastSpellScrollArray ($alignment);
       $castSpellScroll = $castSpellScrollArray[$level];



        $weaponArray = array();
        $weaponNames = array();
        $weaponDamage = array();
    
    //For Random Select weapon
    if(isset($_POST['thecheckBoxRandomWeaponsV3']) && $_POST['thecheckBoxRandomWeaponsV3'] == 1) 
    {
        $weaponArray = getRandomWeapons();

    }
    else
    {
        if(isset($_POST["theWeapons"]))
        {
            foreach($_POST["theWeapons"] as $weapon)
            {
                array_push($weaponArray, $weapon);
            }
        }
    }

    
    
    foreach($weaponArray as $select)
    {
        array_push($weaponNames, getWeapon($select)[0]);
    }
        
    foreach($weaponArray as $select)
    {
        array_push($weaponDamage, getWeapon($select)[1]);
    }
        
        $gearArray = array();
        $gearNames = array();
    
    

    //For Random Select gear
    if(isset($_POST['theCheckBoxRandomGear']) && $_POST['theCheckBoxRandomGear'] == 1) 
    {
        $gearArray = getRandomGear();

        $weaponCount = count($weaponArray);


        for($i = 0; $i < $weaponCount; ++$i)
        {

            if($weaponArray[$i] == "4")
            {
                array_push($gearArray, 26);
            }

            if($weaponArray[$i] == "18")
            {
                array_push($gearArray, 27);
            }

        }

    }
    else
    {
        //For Manually select gear
        if(isset($_POST["theGear"]))
            {
                foreach($_POST["theGear"] as $gear)
                {
                    array_push($gearArray, $gear);
                }
            }

    }

    
        foreach($gearArray as $select)
        {
            array_push($gearNames, getGear($select)[0]);
        }
    
    
    ?>

    
	
<!-- JQuery -->
  <img id="character_sheet"/>
   <section>
       
		<span id="profession">
        <?php
            echo $profession;
            ?></span>
           
        <span id="strength">
        <?php
            echo $strength;
            ?>
        </span>

        
        <span id="strengthMod">
        <?php
            $strengthMod = getModSign($strengthMod);
            echo $strengthMod;
            ?>
        </span>

		<span id="agility">
        <?php
            echo $agility;
            ?>
        </span>

          <span id="agilityMod">
        <?php
            $agilityMod = getModSign($agilityMod);
            echo $agilityMod;
            ?>
        </span>

           
		<span id="stamina">
        <?php
            echo $stamina;
            ?>
        </span>

          <span id="staminaMod">
        <?php
            $staminaMod = getModSign($staminaMod);
            echo $staminaMod;
            ?>
        </span>

		<span id="personality">
        <?php
            echo $personality;
            ?>
        </span>

         <span id="personalityMod">
        <?php
            $personalityMod = getModSign($personalityMod);
            echo $personalityMod;
            ?>
        </span>

		<span id="intelligence">
        <?php
            echo $intelligence;
            ?>
        </span>

         <span id="intelligenceMod">
        <?php
            $intelligenceMod = getModSign($intelligenceMod);
            echo $intelligenceMod;
            ?>
        </span>

		<span id="luck">
        <?php
            echo $luck;
            ?>
        </span>

         <span id="luckMod">
        <?php
            $luckMod = getModSign($luckMod);
            echo $luckMod;
            ?>
        </span>


       <span id="reflex"></span>
       <span id="fort"></span>
       <span id="will"></span>
		  
       
       <span id="gender">
           <?php
           echo $gender;
           ?>
       </span>
       
       
       <span id="dieRollMethod"></span>

       
       <span id="class">Thief</span>
       
       <span id="armourClass"></span>

       <span id="baseAC"></span>
       
       <span id="hitPoints"></span>

       <span id="languages"></span>
       
       <span id="trainedWeapon">
           <?php
           echo $trainedWeapon . ' / ';

           foreach($tradegoods as $td)
           {
               echo $td;
           }
           ?></span>
       <span id="tradeGoods"></span>

       
       <span id="level">
           <?php
                echo $level;
           ?>
        </span>

        
       <span id="xpNextLevel">
           <?php
                echo $xpNextLevel;
           ?>
        </span>

       

       
       <span id="characterName">
           <?php
                echo $characterName;
           ?>
        </span>

              
       <span id="playerName">
           <?php
                echo $playerName;
           ?>
        </span>
       
       
       
              
         <span id="alignment">
           <?php
                echo $alignment;
           ?>
        </span>
        
        <span id="speed"></span>
        
        
        <span id="attackBonus"></span>


              
       <span id="armourName">
           <?php
           if($armourName == "")
           {
               echo $shieldName;
           }
           else if($shieldName == "")
           {
                echo $armourName;
           }
           else
           {
            echo $armourName . " & " . $shieldName;
           }
           ?>
        </span>

        <span id="armourACBonus">
            <?php
                echo $totalAcDefense;
            ?>
        </span>

        
        <span id="armourACCheckPen">
            <?php
                echo $totalAcCheckPen;
            ?>
        </span>
        
        <span id="armourACSpeedPen">
            <?php
            if($speedPenality == 0)
            {
                echo "-";
            }
            else
            {
                echo "-" . $speedPenality;
            }
            ?>
        </span>

        <span id="fumbleDie">
            <?php
            if($armourName == "")
            {
                echo $shieldFumbleDie;
            }
            else
            {
                echo $armourFumbleDie;
            }
            ?>
        </span>

        <span id="criticalDieTable">
            <?php
                echo $criticalDie;
            ?>
        </span>
        
        <span id="luckDie">
            <?php
                echo $luckDie;
            ?>
        </span>

        <span id="initiative">
        </span>
        
        <span id="actionDice">
            <?php
                echo $actionDice;
            ?>
        </span>

        
        <span id="title">
            <?php
                echo $title;
            ?>
        </span>

        
		<p id="birthAugur"><span id="luckySign"></span>: <span id="luckyRoll"></span> (<span id="LuckySignBonus"></span>)</p>


        
        <span id="melee"></span>
        <span id="range"></span>
        
        <span id="meleeDamage"></span>
        <span id="rangeDamage"></span>

       
       
       <span id="weaponsList">
           <?php
           
           foreach($weaponNames as $theWeapon)
           {
               echo $theWeapon;
               echo "<br/>";
           }
           
           ?>  
        </span>

       <span id="weaponsList2">
           <?php
           foreach($weaponDamage as $theWeaponDam)
           {
               echo $theWeaponDam;
               echo "<br/>";
           }
           ?>        
        </span>
       

       <span id="gearList">
           <?php

           $gearCount = count($gearNames);
           $counter = 1;
           
           foreach($gearNames as $theGear)
           {
              echo $theGear;

              if($counter == $gearCount-1)
              {
                  echo " & ";
              }
              elseif($counter > $gearCount-1)
              {
                  echo ".";
              }
              else
              {
                  echo ", ";
              }

              ++$counter;
           }
           ?>
       </span>


       <span id="abilityScoreGeneration">
            <?php
           echo $generationMessage;
           ?>
       </span>


       <span id="backstab">
            <?php
           echo $backstab;
           ?></span>


       <span id="sneakSilently">
            <?php
           echo $sneakSilently;
           ?></span>

       <span id="hideInShadows">
            <?php
           echo $hideInShadows;
           ?></span>

       <span id="pickPocket">
            <?php
           echo $pickPocket;
           ?></span>

       <span id="climb">
            <?php
           echo $climb;
           ?></span>

       <span id="pickLock">
            <?php
           echo $pickLock;
           ?></span>

       <span id="findTrap">
            <?php
           echo $findTrap;
           ?></span>

       <span id="disableTrap">
            <?php
           echo $disableTrap;
           ?></span>

       <span id="forgeDoc">
            <?php
           echo $forgeDoc;
           ?></span>

       <span id="disguiseSelf">
            <?php
           echo $disguiseSelf;
           ?></span>

       <span id="readLanguages">
            <?php
           echo $readLanguages;
           ?></span>

       <span id="handlePoison">
            <?php
           echo $handlePoison;
           ?></span>

       <span id="castSpellScroll">
            <?php
           echo $castSpellScroll;
           ?></span>

       
	</section>
	

		
  <script>
      

  
       let imgData = "images/thief.png";
      
        $("#character_sheet").attr("src", imgData);
      

    
	 
  </script>
		
	
    
</body>
</html>