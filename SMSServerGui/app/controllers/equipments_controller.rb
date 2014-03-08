class EquipmentsController < ApplicationController
  # GET /users
  # GET /users.xml
  def index
    @equipments = Equipment.all

    respond_to do |format|
      format.html # index.html.erb
      format.xml  { render :xml => @equipments }
    end
  end

  # GET /users/1
  # GET /users/1.xml
  def show
    @equipment = Equipment.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.xml  { render :xml => @equipment }
    end
  end

  # GET /users/new
  # GET /users/new.xml
  def new
    @equipment = Equipment.new

    respond_to do |format|
      format.html # new.html.erb
      format.xml  { render :xml => @equipment }
    end
  end

  # GET /users/1/edit
  def edit
    @equipment = Equipment.find(params[:id])
  end

  # POST /users
  # POST /users.xml
  def create
    @equipment = Equipment.new(params[:equipment])

    respond_to do |format|
      if @equipment.save
        flash[:notice] = 'Equipment was successfully created.'
        format.html { redirect_to(@equipment) }
        format.xml  { render :xml => @equipment, :status => :created, :location => @equipment }
      else
        format.html { render :action => "new" }
        format.xml  { render :xml => @equipment.errors, :status => :unprocessable_entity }
      end
    end
  end

  # PUT /users/1
  # PUT /users/1.xml
  def update
    @equipment = Equipment.find(params[:id])

    respond_to do |format|
      if @equipment.update_attributes(params[:equipment])
        flash[:notice] = 'Equipment was successfully updated.'
        format.html { redirect_to(@equipment) }
        format.xml  { head :ok }
      else
        format.html { render :action => "edit" }
        format.xml  { render :xml => @equipment.errors, :status => :unprocessable_entity }
      end
    end
  end

  # DELETE /users/1
  # DELETE /users/1.xml
  def destroy
    @equipment = Equipment.find(params[:id])
    @equipment.destroy

    respond_to do |format|
      format.html { redirect_to(equipments_url) }
      format.xml  { head :ok }
    end
  end
end
